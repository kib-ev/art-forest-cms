<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Catalog\Controller\Catalog' => 'Catalog\Controller\CatalogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'catalog' => array(
                'type' => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/catalog[/][:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        'controller' => 'Catalog\Controller\Catalog',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Catalog' => __DIR__ . '/../view',
        ),
    ),
//    'doctrine' => array(
//        'driver' => array(
//            'banners_module_entities' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(__DIR__ . '/../src/Banners/Model')
//            ),
//            'orm_default' => array(
//                'drivers' => array(
//                    'Banners\Model' => 'banners_module_entities'
//                )
//            )
//        )
//    ),
);
