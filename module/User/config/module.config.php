<?php
namespace User;

use User\Controller\Factory\IndexControllerFactory;
use User\Model\Factory\UserTableFactory;
use User\Model\UserTable;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'register'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:action][/token/:token]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'token' => '[a-f0-9]{32}$'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            UserTable::class => UserTableFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'user/layout/layout' => __DIR__.'/../view/layout/layout.phtml',
            'user/dashboard/register' => __DIR__.'/../view/user/index/register.phtml',
            //'user/dashboard/confirmed-email' => __DIR__.'/../view/user/dashboard/',
            'user/dashboard/new-password' => __DIR__.'/../view/user/index/new-password.phtml',
            'user/dashboard/recovered-password' => __DIR__.'/../view/user/index/recovered-password.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ]
    ]
];
?>