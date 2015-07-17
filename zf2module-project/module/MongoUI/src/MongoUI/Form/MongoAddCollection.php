<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoAddCollection extends Form{
	public function __construct($name = null){
		parent::__construct('MongoAddCollection');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		$this->add([
			'name' => 'collectionName',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Collection name :',
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