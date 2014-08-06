<?php

namespace Upload;

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
                'upload_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $upload = new \Upload\Model\Upload();
                    $resultSetPrototype->setArrayObjectPrototype($upload);
                    $uploadTableGateway = new TableGateway('upload', $dbAdapter, null, $resultSetPrototype);
                    return $uploadTableGateway;
                },
               
                'upload_table' => function ($sm) {
                    $uploadTableGateway = $sm->get('upload_table_gateway');
                    $uploadTable = new \Upload\Model\UploadTable($uploadTableGateway);
                    return $uploadTable;
                 },
                'upload_manager' => function ($sm) {
                    $uploadsTable = $sm->get('upload_table');
                    $uploadsManager = new \Upload\Manager\UploadFileManager($uploadsTable);
                    return $uploadsManager;
                }
            ),
        );
    }

}
