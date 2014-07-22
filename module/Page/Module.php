<?php

namespace Page;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'page_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
                    $page = new \Page\Model\Page();
                    $resultSetPrototype->setArrayObjectPrototype($page);
                    $pageTableGateway = new \Zend\Db\TableGateway\TableGateway('static_pages', $dbAdapter, null, $resultSetPrototype);
                    return $pageTableGateway;
                },
                'page_table' => function ($sm) {
                    $pageTableGateway = $sm->get('page_table_gateway');
                    $pageTable = new \Page\Model\PageTable($pageTableGateway);
                    return $pageTable;
                },
            ),
        );
    }

}