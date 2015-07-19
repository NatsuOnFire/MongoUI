<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use MongoClient;
use MongoCollection;
use MongoId;
use MongoCursorException;
use MongoUI\Form;

class AdminController extends AbstractActionController
{

	private $mc = null;
	private $database = null;
	
    public function indexAction()
    {
    	$view = new ViewModel ();
    	
    	$connected = $this->init ();
    	if($connected === true){
    		
    		$dbs = $this->mc->listDBs();
    		
    		$view->dbs = $dbs['databases'];
    		
    		if (isset ( $_GET ["database"] ) && $_GET ["database"] != "") {
    			$db = $this->mc->selectDB('admin');
    			
    			try{
	    			$users = array();
	    			foreach($this->mc->$db->selectCollection('system.users')->find() as $user){
	    				if($_GET['database'] === $user['db']){
	    					$tempUser = array();
	    					$tempUser["name"] = $user["user"];
	    					$tempUser["roles"] = $user["roles"];
		    				array_push($users, $tempUser);
	    				}
	    			}
					
	    			$view->users = $users;
    			}catch(MongoCursorException $e){
    				$view->error = "You don't have permissions to access users list !";
    			}
    			
    		}
    		   		
    		return $view;
    	}
    }

    public function addAction()
    {
    	$connected = $this->init ();
		
		if($connected === true){
			if (isset ( $_POST ["add"] )) {
				
				if(false === $this->request->isPost()){
					return $this->redirect ()->toUrl ( "/mongomyadmin/admin?database=" . $_POST["database"] );
				}
				
				$post = $this->request->getPost();
				
				$dbs = $this->mc->listDBs();
				
				$mongoAddUserForm = new Form\MongoAddUser(null, $post->database, $dbs['databases']);
				$mongoAddUserForm->setData($post);
				
				if(false === $mongoAddUserForm->isValid()){
					$view = new ViewModel([
							'error' => true,
							'mongoAddUserForm' => $mongoAddUserForm,
							'database' => $post->database
					]);
				
					return $view;
				}
				
				$db = $this->mc->selectDB($post->database);
				$command = array
				(
					"createUser" => $post->user,
					"pwd"        => $post->pwd,
					"roles"      => array
					(
						array("role" => $post->role, "db" => $post->db)
					)
				);
				
				$db->command($command);
				
				return $this->redirect ()->toUrl ( "/mongomyadmin/admin?database=" . $_POST ["database"] );
			} else {
				$view = new ViewModel ();
				
				if (! isset ( $_GET ["database"] ) || $_GET ["database"] == "") {
					$view->setTemplate ( "/mongomyadmin/admin" );
				} else {
					$dbs = $this->mc->listDBs();

					$view->database = $_GET ["database"];
					$view->mongoAddUserForm = new Form\MongoAddUser ( null, $_GET["database"], $dbs['databases']);
				}
				
				return $view;
			}
		}else{
			return $this->redirect ()->toUrl ( "/mongomyadmin");
		}
    }

    public function removeAction()
    {
    	$view = new ViewModel ();
		$connected = $this->init ();
		
		if($connected === true){
			if (! isset ( $_GET ["database"] ) || $_GET ["database"] == "" || ! isset ( $_GET ["name"] ) || $_GET ["name"] == "") {
				$view->setTemplate ( "/mongomyadmin" );
			} else {
				$name = $_GET ["name"];
				$db = $this->mc->selectDB($_GET ["database"]);
				$command = array
				(
						"dropUser" => $name
				);
				
				$db->command($command);
				
				return $this->redirect ()->toUrl ( "/mongomyadmin/admin?database=".$_GET["database"] );
			}
			
			return $view;
		}else{
			return $this->redirect ()->toUrl ( "/mongomyadmin");
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

