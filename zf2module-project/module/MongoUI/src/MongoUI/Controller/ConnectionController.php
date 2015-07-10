<?php

namespace MongoUI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConnectionController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

