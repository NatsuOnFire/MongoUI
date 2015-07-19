<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoAddUser extends Form{
	public function __construct($name = null, $database, array $databases){
		parent::__construct('MongoAddUser');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		$this->add([
			'name' => 'user',
			'attributes' => [
				'type' => 'text'
			],
			'options' => [
				'label' => "Username :",
			],
		]);
		
		$this->add([
			'name' => 'pwd',
			'attributes' => [
				'type' => 'password'
			],
			'options' => [
				'label' => "Password :",
			],
		]);
		
		$dbs = array();
		foreach ($databases as $db){
			$dbs[$db["name"]] = $db["name"];
		}
		
		$this->add([
			'type' => 'Zend\Form\Element\Select',
			'name' => 'role',
			'options' => array(
				'label' => 'Role :',
				'value_options' => array(
					'read' => 'Read',
					'readWrite' => 'Read and Write',
					'dbAdmin' => 'Database Admin',
					'dbOwner' => 'Database Owner',
					'userAdmin' => 'User Admin',
					'readAnyDatabase' => 'Read Any Database',
					'readWriteAnyDatabase' => 'Read and Write Any Database',
					'userAdminAnyDatabase' => 'User Admin Any Database',
					'dbAdminAnyDatabase' => 'Database Admin Any Database'
				),
			)
		]);
		
		$this->add([
			'type' => 'Zend\Form\Element\Select',
			'name' => 'db',
			'options' => array(
				'label' => 'Database :',
				'value_options' => $dbs,
			)
		]);
		
		$this->add([
			'name' => 'database',
			'attributes' => [
					'type' => 'hidden',
					'value' => $database
			],
		]);
		
		$this->add([
			'name' => 'add',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Add'
			]
		]);
	}
}