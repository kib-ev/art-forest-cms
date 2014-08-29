<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',
            'User\Controller\Login' => 'User\Controller\LoginController',
            'User\Controller\Logout' => 'User\Controller\LogoutController',
            'User\Controller\Register' => 'User\Controller\RegisterController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'user_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/User/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'User\Model' => 'user_module_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/user',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/login[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Login',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/logout[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Logout',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/register[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Register',
                                'action' => 'register',
                            ),
                        ),
                    ),
                    'info' => array(
                        'type' => 'segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/info[/][:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
