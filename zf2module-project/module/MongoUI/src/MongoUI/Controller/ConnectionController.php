<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MongoClient;

class ConnectionController extends AbstractActionController
{

    public function indexAction()
    {
        $mc = new MongoClient();
        return new ViewModel();
    }


}

