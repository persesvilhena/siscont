<?php

namespace Cont;

use Cont\Controller\Factory\DashboardControllerFactory;
use Cont\Controller\Factory\RelacaoControllerFactory;
use Cont\Model\MovimentacaoTable;
use Cont\Controller\Factory\MovimentacaoControllerFactory;
use Cont\Model\Factory\MovimentacaoFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'cont.dash' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/cont',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'cont.rel' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/relacao',
                    'defaults' => [
                        'controller' => Controller\RelacaoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'cont.lanc' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/lanc[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\MovimentacaoController::class,
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
            Controller\MovimentacaoController::class => MovimentacaoControllerFactory::class,
            Controller\RelacaoController::class => RelacaoControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            MovimentacaoTable::class => MovimentacaoFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'Cont/dashboard/index' => __DIR__ . '/../view/cont/dashboard/index.phtml',

            //Ticket
            'Cont/movimentacao/delete' => __DIR__ . '/../view/cont/movimentacao/delete.phtml',
            'Cont/movimentacao/edit' => __DIR__ . '/../view/cont/movimentacao/edit.phtml',
            'Cont/movimentacao/plus' => __DIR__ . '/../view/cont/movimentacao/plus.phtml',


            //Paginator
            'Cont/movimentacao/paginator' => __DIR__ . '/../view/cont/movimentacao/paginator.phtml',


        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
