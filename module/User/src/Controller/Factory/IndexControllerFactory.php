<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 14:28
 */

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use User\Controller\IndexController;
use User\Form\UserForm;
use User\Model\UserTable;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);

        $userForm = new UserForm($adapter);
        $userTable = $container->get(UserTable::class);

        return new IndexController($userForm, $userTable);
    }
}