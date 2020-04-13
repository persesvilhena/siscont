<?php

namespace Cont\Controller\Factory;

use Cont\Controller\DashboardController;
use Cont\Model\MovimentacaoTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DashboardControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketTable = $container->get(MovimentacaoTable::class);

        return new DashboardController($ticketTable);
    }
}