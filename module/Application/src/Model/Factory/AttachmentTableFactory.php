<?php

namespace Application\Model\Factory;

use Application\Model\Attachment;
use Application\Model\AttachmentTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class AttachmentTableFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Attachment());

        $tableGateway = new TableGateway('attachments', $adapter, null, $resultSetPrototype);

        return new AttachmentTable($tableGateway);
    }
}