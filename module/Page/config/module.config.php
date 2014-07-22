<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Page\Controller\Page' => 'Page\Controller\PageController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'page' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/page[/][:action][/:url]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'url' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\Page',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Page' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'page_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Page/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Page\Model' => 'page_module_entities'
                )
            )
        )
    ),
);
