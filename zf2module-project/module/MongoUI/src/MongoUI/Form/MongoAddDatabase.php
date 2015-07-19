<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoAddDatabase extends Form{
	public function __construct($name = null){
		parent::__construct('MongoAddDatabase');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		$this->add([
			'name' => 'database',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Database name :',
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