<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 22:39
 */

namespace Auth\Controller\Factory;


use Auth\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get(AuthenticationService::class);

        return new IndexController($authenticationService);
    }
}