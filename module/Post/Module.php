<?php

namespace Post;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                // database
                'comments_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $comment = new \Post\Model\Comment();
                    $resultSetPrototype->setArrayObjectPrototype($comment);
                    $commentsTableGateway = new TableGateway('comments', $dbAdapter, null, $resultSetPrototype);
                    return $commentsTableGateway;
                },
                        
                'comment_table' => function ($sm) {
                    $commentsTableGateway = $sm->get('comments_table_gateway');
                    $commentTable = new \Post\Model\CommentTable($commentsTableGateway);
                    return $commentTable;
                },
                
                'posts_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $post = new \Post\Model\Post();
                    $resultSetPrototype->setArrayObjectPrototype($post);
                    $postsTableGateway = new TableGateway('posts', $dbAdapter, null, $resultSetPrototype);
                    return $postsTableGateway;
                },
                'post_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $post = new \Post\Model\Post();
                    $resultSetPrototype->setArrayObjectPrototype($post);
                    $postTableGateway = new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                    return $postTableGateway;
                },
                        
                'post_table' => function ($sm) {
                    $postTableGateway = $sm->get('post_table_gateway');
                    $postTable = new \Post\Model\PostTable($postTableGateway);
                    return $postTable;
                },
                
                'likes_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $like = new \Post\Model\Like();
                    $resultSetPrototype->setArrayObjectPrototype($like);
                    $likesTableGateway = new TableGateway('likes', $dbAdapter, null, $resultSetPrototype);
                    return $likesTableGateway;
                },
                        
                'like_table' => function ($sm) {
                    $likesTableGateway = $sm->get('likes_table_gateway');
                    $likeTable = new \Post\Model\LikeTable($likesTableGateway);
                    return $likeTable;
                },
                'attachments_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $attachment = new \Post\Model\Attachment();
                    $resultSetPrototype->setArrayObjectPrototype($attachment);
                    $attachmentsTableGateway = new TableGateway('attachments', $dbAdapter, null, $resultSetPrototype);
                    return $attachmentsTableGateway;
                },
                        
                'attachment_table' => function ($sm) {
                    $attachmentsTableGateway = $sm->get('attachments_table_gateway');
                    $attachmentTable = new \Post\Model\AttachmentTable($attachmentsTableGateway);
                    return $attachmentTable;
                },
                'favorites_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $favorite = new \Post\Model\Favorite();
                    $resultSetPrototype->setArrayObjectPrototype($favorite);
                    $favoritesTableGateway = new TableGateway('favorites', $dbAdapter, null, $resultSetPrototype);
                    return $favoritesTableGateway;
                },
                        
                'favorite_table' => function ($sm) {
                    $favoritesTableGateway = $sm->get('favorites_table_gateway');
                    $favoriteTable = new \Post\Model\FavoriteTable($favoritesTableGateway);
                    return $favoriteTable;
                }  
            ),
        );
    }

}
