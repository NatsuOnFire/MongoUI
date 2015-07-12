<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MongoClient;

use MongoUI\Form;

class ConnectionController extends AbstractActionController
{

    public function indexAction()
    {
        $view = new ViewModel;

        $view->mongoAuthForm = new Form\MongoAuth;
        return $view;
    }

    public function connectAction()
    {
        if(false === $this->request->isPost()){
            return $this->redirect()->toRoute(null, ['controller' => 'connection', 'action' => 'index']);
        }

        $post = $this->request->getPost();

        $mongoAuthForm = new Form\MongoAuth;
        //$mongoAuth->setInputFilter(new InputFilter\User);
        $mongoAuthForm->setData($post);

        if(false === $mongoAuthForm->isValid()){
            $view = new ViewModel([
                'error' => true,
                'mongoAuthForm' => $mongoAuthForm,
            ]);
            $view->setTemplate('MongoUI/connection/index');
            return $view;
        }

        $data = $mongoAuthForm->getData();


        var_dump($data);

        //return $this->redirect()->toRoute(null, ['controller' => 'connection', 'action' => 'confirmation']);
    }


}

