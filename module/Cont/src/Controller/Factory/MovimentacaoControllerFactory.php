<?php

namespace Cont\Controller\Factory;

use Cont\Controller\MovimentacaoController;
use Cont\Model\MovimentacaoTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MovimentacaoControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketTable = $container->get(MovimentacaoTable::class);

        return new MovimentacaoController($ticketTable);
    }
}