<?php

namespace Cont\Model\Factory;

use Cont\Model\Movimentacao;
use Cont\Model\MovimentacaoTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class MovimentacaoFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Movimentacao());

        $tableGateway = new TableGateway('cont', $adapter, null, $resultSetPrototype);

        return new MovimentacaoTable($tableGateway);
    }
}