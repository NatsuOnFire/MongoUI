<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MongoClient;


class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $this->redirect()->toUrl('/mongomyadmin/connection/index');
        $view = new ViewModel;
        return $view;
    }

}

