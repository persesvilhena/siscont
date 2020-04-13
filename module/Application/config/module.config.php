<?php

namespace Application;

use Application\Controller\Factory\DashboardControllerFactory;
use Application\Model\AttachmentTable;
use Application\Model\TicketTable;
use Application\Controller\Factory\TicketControllerFactory;
use Application\Model\Factory\AttachmentTableFactory;
use Application\Model\Factory\TicketTableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'ticket' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/ticket[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\TicketController::class,
                        'action'     => 'plus',
                    ],
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*', //exemplo
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\DashboardController::class => DashboardControllerFactory::class,
            Controller\TicketController::class => TicketControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            TicketTable::class => TicketTableFactory::class,
            AttachmentTable::class => AttachmentTableFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/empty'             => __DIR__ . '/../view/layout/empty.phtml',
            'Application/dashboard/index' => __DIR__ . '/../view/application/dashboard/index.phtml',

            //Ticket
            'Application/ticket/delete' => __DIR__ . '/../view/application/ticket/delete.phtml',
            'Application/ticket/edit' => __DIR__ . '/../view/application/ticket/edit.phtml',
            'Application/ticket/plus' => __DIR__ . '/../view/application/ticket/plus.phtml',

            //Partials
            'Application/ticket/form' => __DIR__ . '/../view/application/ticket/form.phtml',

            //Paginator
            'Application/ticket/paginator' => __DIR__ . '/../view/application/ticket/paginator.phtml',

        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
