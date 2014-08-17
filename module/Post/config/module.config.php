<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Post\Controller\Post' => 'Post\Controller\PostController',
            'Post\Controller\Attachment' => 'Post\Controller\AttachmentController',
            'Post\Controller\Like' => 'Post\Controller\LikeController',
            'Post\Controller\Comment' => 'Post\Controller\CommentController',
            'Post\Controller\Favorite' => 'Post\Controller\FavoriteController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Post' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'post_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Post/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Post\Model' => 'post_module_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'post' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/post[/][:action][/][:post_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'post_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Post',
                    ),
                ),
            ),
            'attachment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/attachment[/][:action][/][:post_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'post_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Attachment',
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
                        'controller' => 'Post\Controller\Like',
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
                        'controller' => 'Post\Controller\Comment',
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
                        'controller' => 'Post\Controller\Favorite',
                    ),
                ),
            ),
        ),
    ),
);
