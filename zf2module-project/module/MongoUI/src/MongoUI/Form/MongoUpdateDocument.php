<?php
namespace MongoUI\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class MongoUpdateDocument extends Form{
	public function __construct($name = null, array $document, $collection){
		parent::__construct('MongoUpdateDocument');
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		
		foreach ($document as $key => $value){
			$this->add([
				'name' => $key,
				'attributes' => [
					'type' => 'text',
					'value' => $value
				],
				'options' => [
					'label' => ucfirst($key),
				],
			]);
		}
		
		$this->add([
				'name' => 'tempId',
				'attributes' => [
						'type' => 'hidden',
						'value' => $document["_id"]
				],
		]);
		
		$this->add([
			'name' => 'collection',
			'attributes' => [
					'type' => 'hidden',
					'value' => $collection->getName()
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