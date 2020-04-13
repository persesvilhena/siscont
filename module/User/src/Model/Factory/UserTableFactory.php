<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 26/02/2019
 * Time: 18:34
 */

namespace User\Model\Factory;


use Interop\Container\ContainerInterface;
use User\Model\User;
use User\Model\UserTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;


class UserTableFactory implements FactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());

        $tableGateway = new TableGateway('users', $adapter, null, $resultSetPrototype);

        return new UserTable($tableGateway);
    }
}