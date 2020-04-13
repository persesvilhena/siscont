<?php

namespace Application\Controller\Factory;

use Application\Controller\TicketController;
use Application\Model\AttachmentTable;
use Application\Model\TicketTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TicketControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ticketTable = $container->get(TicketTable::class);
        $attachmentTable = $container->get(AttachmentTable::class);

        return new TicketController($ticketTable, $attachmentTable);
    }
}