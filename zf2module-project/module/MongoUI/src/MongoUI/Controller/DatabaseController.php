<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use MongoClient;
use MongoDB;
use MongoCollection;
use MongoId;
use MongoUI\Form;

class DatabaseController extends AbstractActionController
{
	
	private $mc = null;
	private $database = null;
	
    public function addAction()
    {
    	$connected = $this->init ();
    	
    	if($connected === true){
    		if (isset ( $_POST ["add"] )) {
    			
    			if(false === $this->request->isPost()){
    				return $this->redirect ()->toUrl ( "/mongomyadmin/admin");
    			}
    			
    			$post = $this->request->getPost();
    			
    			$db = new MongoDB($this->mc, $post->database);
    			$db->createCollection('users');
    			$collection = new MongoCollection ( $db, "users" );
    			$collection->drop();

    			return $this->redirect()->toUrl("/mongomyadmin/admin");
    		}else{
    			$view = new ViewModel ();
    			
    			$view->mongoAddDatabaseForm = new Form\MongoAddDatabase;
    			
    			return $view;
    		}
    	}
    }

    public function removeAction()
    {
    	$connected = $this->init ();
    	
    	if($connected === true){
    		if (isset ( $_GET ["database"] ) && $_GET ["database"] != "") {
    			$db = $this->mc->selectDB('admin');
    			foreach($this->mc->$db->selectCollection('system.users')->find(array("db" => $_GET["database"])) as $user){
    				$db = $this->mc->selectDB($_GET ["database"]);
    				$command = array
    				(
    						"dropUser" => $user["user"]
    				);
    				
    				$db->command($command);
    			}
    			    			
    			$db = $this->mc->selectDB($_GET['database']);
    			$db->drop();
    		}
    		return $this->redirect ()->toUrl ( "/mongomyadmin/admin");
    	}
    }

    /**
     * Méthode d'initialisation des attributs Mongo.
     */
    private function init() {
    	$container = new Container ( 'mongoUI' );
    	if (! $container->offsetExists ( 'connected' )) {
    		$this->redirect ()->toUrl ( '/mongomyadmin/connection/index' );
    		return false;
    	} else {
    		$this->mc = new MongoClient ( $container->mongoClient );
    		$this->database = $container->database;
    		return true;
    	}
    }

}

