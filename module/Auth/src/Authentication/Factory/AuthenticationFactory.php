<?php


namespace Auth\Authentication\Factory;

use Auth\Authentication\Adapter;
use Interop\Container\ContainerInterface;
use User\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $session = new Session();

        $user = $container->get(UserTable::class);

        return new AuthenticationService($session, new Adapter($user));
    }
}