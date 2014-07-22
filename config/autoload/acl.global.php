
<?php

return array(
    'acl' => array(
        /**
         * By default the ACL is stored in this config file.
         * If you activate the database_storage ACL will be constructed from the database via Doctrine
         * and the roles and resources defined in this config wil be ignored.
         * 
         * Defaults to false.
         */
        'use_database_storage' => false,
        /**
         * The route where users are redirected if access is denied.
         * Set to empty array to disable redirection.
         */
        'redirect_route' => array(
            'params' => array(
                'controller' => 'users',
            ),
            'options' => array(
                'name' => 'users/register',
            ),
        ),
        /**
         * Access Control List
         * -------------------
         */
        'roles' => array(
            'guest' => null,
            'member' => 'guest',
            'admin' => 'member',
        ),
        'resources' => array(
            'allow' => array(
                /* Users Module */
                'Users\Controller\Index' => array(
                    'index' => 'guest',
                ),
                'Users\Controller\Auth' => array(
                    'index' => 'guest',
                    'login' => 'guest',
                    'logout' => 'member',
                    'process' => 'guest',
                    'confirm' => 'guest',
                    'forgot' => 'guest',
                    'forgot-process' => 'guest',
                    'change' => 'guest',
                    'change-process' => 'guest'
                ),
                'Users\Controller\Register' => array(
                    'index' => 'guest',
                    'process' => 'guest',
                    'test' => 'guest',
                    'confirm' => 'guest',
                    'legal' => 'guest',
                    'legal-process' => 'guest',
                    'physical' => 'guest',
                    'physical-process' => 'guest',
                    'individual' => 'guest',
                    'individual-process' => 'guest',
                ),
                'Users\Controller\Activate' => array(
                    'index' => 'member',
                    'control' => 'admin'
                ),
                'Users\Controller\UserData' => array(
                    'ajax-set-avatar' => 'member'
                ),
                /* Dialogs Module */
                'Dialogs\Controller\Dialogs' => array(
                    'index' => 'admin',
                    'open' => 'member',
                    'send' => 'member',
                    'delete' => 'member',
                    'list' => 'member',
                ),
                /* Banners Module */
                'Banner\Controller\Banner' => array(
                    'index' => 'member',
                    'list' => 'member',
                ),
                'Banners\Controller\Banners' => array(
                    'index' => 'member',
                    'add' => 'member',
                ),
                'Banners\Controller\Simple' => array(
                    'index' => 'member',
                    'add' => 'member',
                    'process' => 'member',
                    'ajax-process' => 'member',
                ),
                'Banners\Controller\Vip' => array(
                    'index' => 'member',
                    'add' => 'member',
                    'process' => 'member',
                    'ajax-process' => 'member',
                ),
                'Banners\Controller\Logo' => array(
                    'index' => 'member',
                    'add' => 'member',
                    'process' => 'member',
                    'ajax-process' => 'member',
                ),
                'Banners\Controller\Sale' => array(
                    'index' => 'member',
                    'add' => 'member',
                    'process' => 'member',
                    'ajax-process' => 'member',
                ),
                /* Post Module */
                'Post\Controller\Post' => array(
                    'edit' => 'member',
                    'list' => 'guest',
                    'add' => 'member',
                    'details' => 'guest',
                    'delete' => 'member',
                    'refresh' => 'member',
                    'tags' => 'guest'
                ),
                'Post\Controller\Attachment' => array(
                    'delete' => 'member',
                ),
                'Post\Controller\Comment' => array(
                    'delete' => 'member',
                    'save' => 'member',
                ),
                'Post\Controller\Like' => array(
                    'like' => 'member'
                ),
                'Post\Controller\Favorite' => array(
                    'delete' => 'member',
                    'index' => 'admin',
                    'favorite' => 'member',
                    'list' => 'member'
                ),
                'Page\Controller\Page' => array(
                    'index' => 'admin',
                    'list' => 'admin',
                    'add' => 'admin',
                    'edit' => 'admin',
                    'process' => 'admin',
                    'delete' => 'admin',
                    'view' => 'guest',
                    'json-feedback' => 'guest',
                ),
                /* Search Module */
                'Search\Controller\Search' => array(
                    'index' => 'guest',
                    'generate-index' => 'guest',
                    'display' => 'guest',
                    'process' => 'guest',
                    'update' => 'member',
                    'list' => 'guest',
                ),
                'Search\Controller\Filter' => array(
                    'filter' => 'guest',
                    'ajax-filter' => 'guest',
                    'ajax-catalog' => 'guest',
                ),
                'Post\Controller\Comment' => array(
                    'delete' => 'member',
                    'save' => 'member',
                ),
                'Post\Controller\Like' => array(
                    'like' => 'member'
                ),
                /* Catalog Module */
                'Catalog\Controller\Catalog' => array(
                    'index' => 'admin',
                    'add' => 'admin',
                ),
                /* Global */
                'Application\Controller\Index' => array(
                    'index' => 'guest',
                ),
            ),
            'deny' => array(
            // ...
            )
        )
    )
);
