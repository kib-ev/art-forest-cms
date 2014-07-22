<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Banner\Controller\Banner' => 'Banner\Controller\BannerController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'banner' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/banner[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Banner\Controller\Banner',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Banner' => __DIR__ . '/../view',
        ),
    ),
);
