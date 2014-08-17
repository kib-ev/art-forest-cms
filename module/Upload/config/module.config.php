<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Upload\Controller\Upload' => 'Upload\Controller\UploadController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'upload' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/upload[/][:action][/:upload_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'upload_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Upload\Controller\Upload',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Upload' => __DIR__ . '/../view'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'upload_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Upload/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Upload\Model' => 'upload_module_entities'
                )
            )
        )
    ),
);

