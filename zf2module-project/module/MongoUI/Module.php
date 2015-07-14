<?php
namespace MongoUI;

use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\EventManager\EventInterface;

class Module
{
	public function onBootstrap(EventInterface $em)
	{
		$manager = $em->getApplication()->getServiceManager()->get('Zend\Session\ManagerInterface');
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
