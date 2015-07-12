<?php
/**
 * Created by PhpStorm.
 * User: Shake
 * Date: 12/07/2015
 * Time: 18:36
 */
	namespace MongoUI\Form;

    use Zend\Form\Form;
    use Zend\Form\Element;

    class MongoAuth extends Form{
        public function __construct($name = null){
            parent::__construct('MongoAuth');

            $this->setAttribute('method', 'post');
            $this->setAttribute('enctype', 'multipart/form-data');
            $this->add([
                'name' => 'username',
                'attributes' => [
                    'type' => 'text',
                    'required' => 'required'
                ],
                'options' => [
                    'label' => 'Username',
                ],
            ]);

            $this->add([
                'name' => 'password',
                'attributes' => [
                    'type' => 'password',
                    'required' => 'required'
                ],
                'options' => [
                    'label' => 'Mot de passe',
                ],
            ]);

            $this->add([
                'name' => 'url',
                'attributes' => [
                    'type' => 'text',
                    'required' => 'required'
                ],
                'options' => [
                    'label' => 'URL',
                ],
            ]);
            $this->add([
                'name' => 'port',
                'attributes' => [
                    'type' => 'text',
                    'required' => 'required',
                    'value' => '27017'
                ],
                'options' => [
                    'label' => 'Port',
                ],
            ]);
            $this->add([
            	'name' => 'database',
            	'attributes' => [
            		'type' => 'text',
            		'required' => 'required'
            	],
            	'options' => [
            		'label' => 'Database',
            	],
            ]);

            $this->add([
                'name' => 'connect',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Connect'
                ]
            ]);
        }
    }