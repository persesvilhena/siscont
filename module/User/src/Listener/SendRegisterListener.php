<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 00:59
 */

namespace User\Listener;

use Core\Stdlib\CurrentUrl;
use User\Controller\IndexController;
use User\Mail\Mail;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;

class SendRegisterListener extends AbstractListenerAggregate
{
    use CurrentUrl;

    private $serviceManager;

    public function __construct(ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;
    }

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1){
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
            IndexController::class,
            'registerAction.post',
            [$this, 'onSendRegister'],
            $priority
            );
    }

    public function onSendRegister(Event $event){
        /**
         * @var $controller IndexController
         * @var $user \User\Model\User
         * @var $transport \Zend\Mail\Transport\Smtp
         */

        $controller = $event->getTarget();
        $user = $event->getParams()['data'];

        $transport = $this->serviceManager->get('core.transport.smtp');
        $view = $this->serviceManager->get('View');

        $data = $user->getArrayCopy();
        $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
        $data['host'] = $this->getUrl($controller->getRequest());

        $email = new Mail($transport, $view, 'user/mailer/register');
        $email->setSubject('Cadastro help Desk ZF3 na patrica')
            ->setTo(strtolower(trim($user->email)))
            ->setData($data)
            ->prepare()
            ->send();
    }
}