<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 27/02/2019
 * Time: 21:14
 */
namespace Auth;


return [
    'router' => [
        'routes' => [
            'auth.login' => [
                'type' => \Zend\Router\Http\Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'auth.logout' => [
                'type' => \Zend\Router\Http\Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'logout'
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => \Auth\Controller\Factory\IndexControllerFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'auth/dashboard/login' => __DIR__ . '/../view/auth/index/login.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];