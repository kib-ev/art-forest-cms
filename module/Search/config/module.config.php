<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Search\Controller\Search' => 'Search\Controller\SearchController',
            'Search\Controller\Filter' => 'Search\Controller\FilterController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/search[/][:action][/:query]',
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
            'filter' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/search/filter[/][:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Search\Controller\Filter',
                        'action' => 'filter'
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
    'service_manager' => array (
        'factories' => array(
            'search_module_options' => 'Search\Service\Factory\ModuleOptionsFactory',
        ),
    ),
//    'doctrine' => array(
//        'driver' => array(
//            'search_module_entities' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(__DIR__ . '/../src/Search/Model')
//            ),
//            'orm_default' => array(
//                'drivers' => array(
//                    'Search\Model' => 'search_module_entities'
//                )
//            )
//        )
//    ),
);
