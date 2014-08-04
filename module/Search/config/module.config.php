<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Search\Controller\Search' => 'Search\Controller\SearchController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/post/search[/][:action][/:query]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Search\Controller\Search',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Search' => __DIR__ . '/../view',
        ),
    ),
    'module_config' => array(
        'search_index' => __DIR__ . '/../../../data/search_index'
    ),
    'service_manager' => array(
        'factories' => array(
            'search_module_options' => 'Search\Service\Factory\ModuleOptionsFactory',
        ),
    ),
);
