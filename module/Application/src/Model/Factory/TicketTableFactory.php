<?php

namespace Application\Model\Factory;

use Application\Model\Ticket;
use Application\Model\TicketTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class TicketTableFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Ticket());

        $tableGateway = new TableGateway('tickets', $adapter, null, $resultSetPrototype);

        return new TicketTable($tableGateway);
    }
}