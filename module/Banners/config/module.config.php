<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Banners\Controller\Banners' => 'Banners\Controller\BannersController',
            'Banners\Controller\Simple' => 'Banners\Controller\SimpleController',
            'Banners\Controller\Sale' => 'Banners\Controller\SaleController',
            'Banners\Controller\Logo' => 'Banners\Controller\LogoController',
            'Banners\Controller\Vip' => 'Banners\Controller\VipController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'banners' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/banners',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Banners\Controller\Banners',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'simple' => array(
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/simple[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Banners\Controller\Simple',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'sale' => array(
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/sale[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Banners\Controller\Sale',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'logo' => array(
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/logo[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Banners\Controller\Logo',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'vip' => array(
                        'type' => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/vip[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Banners\Controller\Vip',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Banners' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'banners_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Banners/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Banners\Model' => 'banners_module_entities'
                )
            )
        )
    ),
);
