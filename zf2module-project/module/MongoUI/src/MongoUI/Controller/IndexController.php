<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use MongoClient;
use MongoCollection;
use MongoId;
use MongoUI\Form;

class IndexController extends AbstractActionController {
	
	private $mc = null;
	private $database = null;
	private $db = null;
	
	/**
	 * Listage des collections et document suivant la collection choisie.
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function indexAction() {
		$view = new ViewModel ();
		
		$connected = $this->init ();
		
		if($connected === true){
			$collections = $this->db->listCollections ();
			
			$view->database = $this->database;
			$view->collections = $collections;
			
			if (isset ( $_GET ["collection"] ) && $_GET ["collection"] != "") {
				$collection = new MongoCollection ( $this->db, $_GET ["collection"] );
				$cursor = $collection->find ();
				
				$keys = array ();
				foreach ( $cursor as $doc ) {
					$keys = $this->getKeys ( $doc );
					break;
				}
				
				$view->header = $keys;
				$view->cursor = $cursor;
			}
			
			return $view;
		}
	}
	
	/**
	 * Mise à jour d'un document.
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function updateAction() {
		$connected = $this->init ();
		
		if($connected === true){
			if (isset ( $_POST ["update"] )) {
				
				if(false === $this->request->isPost()){
					return $this->redirect ()->toUrl ( "/mongomyadmin?collection=" . $_POST["collection"] );
				}
				
				$post = $this->request->getPost();
				
				$id = $post->tempId;
				$collection = new MongoCollection ( $this->db, $post->collection );
				
				$set = array ();
				foreach ( $post as $key => $value ) {
					if ($key != "collection" && $key != "update" && $key != "tempId") {
						if ($key === "_id") {
							$set [$key] = new MongoId ( $value );
						} else {
							$set [$key] = $value;
						}
					}
				}
				
				$collection->update ( 
						array ("_id" => new MongoId ( $id ) ), 
						$set, array (
						"upsert" => true 
				) );
				
				return $this->redirect ()->toUrl ( "/mongomyadmin?collection=" . $post->collection);
			} else {
				$view = new ViewModel ();
				
				if (! isset ( $_GET ["collection"] ) || $_GET ["collection"] == "" || ! isset ( $_GET ["id"] ) || $_GET ["id"] == "") {
					$view->setTemplate ( "/mongomyadmin" );
				} else {
					$id = $_GET ["id"];
					$collection = new MongoCollection ( $this->db, $_GET ["collection"] );
					$document = $collection->findOne ( array (
							'_id' => new MongoId ( $id ) 
					) );
					
					$view->collection = $_GET ["collection"];
					$view->mongoUpdateDocumentForm = new Form\MongoUpdateDocument ( null, $document, $collection );
				}
				
				return $view;
			}
		}
	}
	
	/**
	 * Suppression d'un document.
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function removeAction() {
		$view = new ViewModel ();
		$connected = $this->init ();
		
		if($connected === true){
			if (! isset ( $_GET ["collection"] ) || $_GET ["collection"] == "" || ! isset ( $_GET ["id"] ) || $_GET ["id"] == "") {
				$view->setTemplate ( "/mongomyadmin" );
			} else {
				$id = $_GET ["id"];
				$collection = new MongoCollection ( $this->db, $_GET ["collection"] );
				$collection->remove ( array (
						'_id' => new MongoId ( $id ) 
				) );
				
				return $this->redirect ()->toUrl ( "/mongomyadmin?collection=".$_GET["collection"] );
			}
			
			return $view;
		}
	}
	
	/**
	 * Ajout d'un document.
	 */
	public function addAction() {
		$connected = $this->init ();
		
		if($connected === true){
			if (isset ( $_POST ["add"] )) {
				
				if(false === $this->request->isPost()){
					return $this->redirect ()->toUrl ( "/mongomyadmin?collection=" . $_POST["collection"] );
				}
				
				$post = $this->request->getPost();
				
				$collection = new MongoCollection ( $this->db, $post->collection);
				
				$document = array ();
				foreach ( $post as $key => $value ) {
					if ($key != "collection" && $key != "add") {
						$document[$key] = $value;
					}
				}
				
				$collection->insert($document);
				
				return $this->redirect ()->toUrl ( "/mongomyadmin?collection=" . $_POST ["collection"] );
			} else {
				$view = new ViewModel ();
				
				if (! isset ( $_GET ["collection"] ) || $_GET ["collection"] == "") {
					$view->setTemplate ( "/mongomyadmin" );
				} else {
					$collection = new MongoCollection ( $this->db, $_GET ["collection"] );
					$document = $collection->findOne();
					
					$keys = $this->getKeys($document);
					
					$view->collection = $_GET ["collection"];
					$view->mongoAddDocumentForm = new Form\MongoAddDocument ( null, $keys, $collection );
				}
				
				return $view;
			}
		}
	}
	
	public function logoutAction(){

		$this->init();
		$this->mc->close();
		unset($_SESSION['mongoUI']);
		
		return $this->redirect ()->toUrl ( '/mongomyadmin/connection/index' );
	}
	
	/**
	 * Fonction retournant les en-têtes d'un document
	 * 
	 * @param array $array
	 */
	private function getKeys(array $array) {
		$keys = array ();
		while ( $data = current ( $array ) ) {
			array_push ( $keys, key ( $array ) );
			next ( $array );
		}
		
		return $keys;
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

