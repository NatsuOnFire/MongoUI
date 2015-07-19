<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoUpdateUser extends Form{
	public function __construct($name = null, $database, $user, array $databases){
		parent::__construct('MongoUpdateUser');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		$this->add([
			'name' => 'user',
			'attributes' => [
				'type' => 'text',
				'value' => $user['user'],
				'disabled' => 'disabled'
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
			),
            'attributes' => array(
                'value' => $user['roles'][0]['role']
            )
		]);
		
		$this->add([
			'type' => 'Zend\Form\Element\Select',
			'name' => 'db',
			'options' => array(
				'label' => 'Database :',
				'value_options' => $dbs,
			),
            'attributes' => array(
                'value' => $user['roles'][0]['db']
            )
		]);
		
		$this->add([
			'name' => 'id',
			'attributes' => [
				'type' => 'hidden',
				'value' => $user['_id']
			],
		]);
		
		$this->add([
			'name' => 'username',
			'attributes' => [
				'type' => 'hidden',
				'value' => $user['user']
			]
		]);
		
		$this->add([
			'name' => 'database',
			'attributes' => [
					'type' => 'hidden',
					'value' => $database
			],
		]);
		
		$this->add([
			'name' => 'update',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Update'
			]
		]);
	}
}