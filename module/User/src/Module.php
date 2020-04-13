<?php

namespace User;

use User\Listener\SendRecoverPasswordListener;
use User\Listener\SendRegisterListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements BootstrapListenerInterface{
    public function getConfig(){
        return include __DIR__.'/../config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /**
         * @var $eventManager \Zend\EventManager\EventManager
         * @var $serviceManager \Zend\ServiceManager\ServiceManager
         */

        $eventManager = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();

        (new SendRegisterListener($serviceManager))->attach($eventManager, 100);
        (new SendRecoverPasswordListener($serviceManager))->attach($eventManager, 100);
    }
}