<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use MongoClient;
use MongoCollection;
use MongoId;
use MongoUI\Form;

class CollectionController extends AbstractActionController
{

	private $mc = null;
	private $database = null;
	private $db = null;
	
    public function addAction()
    {
    	$connected = $this->init ();
    	
    	if($connected === true){
    		if (isset ( $_POST ["add"] )) {
    			
    			if(false === $this->request->isPost()){
    				return $this->redirect ()->toUrl ( "/mongomyadmin");
    			}
    			
    			$post = $this->request->getPost();
    			
    			$this->db->createCollection($post->collectionName);
    			
    			return $this->redirect()->toUrl("/mongomyadmin");
    		}else{
    			$view = new ViewModel ();
    			
    			$view->mongoAddCollectionForm = new Form\MongoAddCollection;
    			
    			return $view;
    		}
    	}
    }
    
    public function removeAction()
    {   	
    	$connected = $this->init ();
    	
    	if($connected === true){
    		if (isset ( $_GET ["collection"] ) && $_GET ["collection"] != "") {
    			$collection = new MongoCollection ( $this->db, $_GET["collection"] );
    			$collection->drop();
    		}
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
    		$this->db = $this->mc->selectDB ( $this->database );
    		return true;
    	}
    }

}

