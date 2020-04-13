<?php

namespace Cont\Listener;

use Cont\Controller\DashboardController;
use Cont\Controller\MovimentacaoController;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class CheckAuthenticationListener extends AbstractListenerAggregate
{
    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();

        $this->listeners[] = $sharedEvents->attach(
            DashboardController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'dispatch'],
            $priority
        );

        $this->listeners[] = $sharedEvents->attach(
            MovimentacaoController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'dispatch'],
            $priority
        );
    }

    public function dispatch(Event $event)
    {
        /**
         * @var $controller \Zend\Mvc\Controller\AbstractActionController
         */
        $controller = $event->getTarget();

        if (! $controller->identity()) {
            $controller->flashMessenger('Para acessar você deve fazer login.');

            return $controller->redirect()->toRoute('auth.login');
        }
    }
}