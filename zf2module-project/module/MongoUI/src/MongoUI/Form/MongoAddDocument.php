<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoAddDocument extends Form{
	public function __construct($name = null, array $keys, $collection){
		parent::__construct('MongoAddDocument');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		foreach ($keys as $key){
			if($key != "_id"){
				$this->add([
					'name' => $key,
					'attributes' => [
						'type' => 'text'
					],
					'options' => [
						'label' => ucfirst($key)." :",
					],
				]);
			}
		}
		
		$this->add([
			'name' => 'collection',
			'attributes' => [
					'type' => 'hidden',
					'value' => $collection->getName()
			],
		]);
		
		$this->add([
			'name' => 'numberField',
			'attributes' => [
				'type' => 'hidden',
				'value' => 1,
				'id' => 'numberField'
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