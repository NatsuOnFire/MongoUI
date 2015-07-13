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
		$this->initializeSession($em);
	}
	
	public function initializeSession($em)
	{
		$config = $em->getApplication()
					->getServiceManager()
					->get('Config');
	
		$sessionConfig = new SessionConfig();
		$sessionConfig->setOptions($config['session']);
	
		$sessionManager = new SessionManager($sessionConfig);
		$sessionManager->start();
	
		Container::setDefaultManager($sessionManager); //au cas ou on utilise plusieurs SessionManagers
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
