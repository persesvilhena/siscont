<?php

namespace Cont\Controller\Factory;

use Cont\Controller\RelacaoController;
use Cont\Model\MovimentacaoTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RelacaoControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketTable = $container->get(MovimentacaoTable::class);

        return new RelacaoController($ticketTable);
    }
}