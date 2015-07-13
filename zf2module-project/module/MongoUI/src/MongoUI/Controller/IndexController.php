<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use MongoClient;
use MongoCollection;


class IndexController extends AbstractActionController
{

    public function indexAction()
    {
    	$view = new ViewModel;
    	
    	$container = new Container('mongoUI');
    	if ( !$container->offsetExists('connected') ){
    		$this->redirect()->toUrl('/mongomyadmin/connection/index');
    	}else{
    		$mc = new MongoClient($container->mongoClient);
    		$db = $mc->selectDB($container->database);
    		
    		$collections = $db->listCollections();		
    		
    		$view->database = $container->database;
    		$view->collections = $collections;
    		
    		if(isset($_GET["collection"]) && $_GET["collection"] != ""){
    			$collection = new MongoCollection($db, $_GET["collection"]);
    			$cursor = $collection->find();
    			
    			$keys = array();
    			foreach ($cursor as $doc) {
    				while ($data = current($doc)) {
    					array_push($keys, key($doc));
    					next($doc);
    				}
    				break;
    			}
    			
    			$view->header = $keys;
    			$view->cursor = $cursor;
    		}
    	}
        
        return $view;
    }

}

