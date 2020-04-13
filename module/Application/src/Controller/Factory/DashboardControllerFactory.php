<?php

namespace Application\Controller\Factory;

use Application\Controller\DashboardController;
use Application\Model\TicketTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DashboardControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketTable = $container->get(TicketTable::class);

        return new DashboardController($ticketTable);
    }
}