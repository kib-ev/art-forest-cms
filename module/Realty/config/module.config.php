<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Realty\Controller\Realty' => 'Realty\Controller\RealtyController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Realty' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'realty_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Realty/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Realty\Model' => 'realty_module_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'realty' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/realty[/][:action][/][:realty_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'realty_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Realty\Controller\Realty',
                        'action' => 'index'
                    ),
                ),
            ),
            'attachment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/attachment[/][:action][/][:realty_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'realty_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Realty\Controller\Attachment',
                    ),
                ),
            ),
            'like' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/like[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Realty\Controller\Like',
                    ),
                ),
            ),
            'comment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/comment[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Realty\Controller\Comment',
                    ),
                ),
            ),
            'favorite' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/favorite[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Realty\Controller\Favorite',
                    ),
                ),
            ),
        ),
    ),
);
