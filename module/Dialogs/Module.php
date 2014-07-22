<?php

namespace Dialogs;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'dialogs_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $dialog = new \Dialogs\Model\Dialog();
                    $resultSetPrototype->setArrayObjectPrototype($dialog);
                    $dialogsTableGateway = 
                        new TableGateway('dialogs', $dbAdapter, null, $resultSetPrototype);
                    return $dialogsTableGateway;
                },
                'dialogs_table' => function ($sm) {
                    $dialogsTableGateway = $sm->get('dialogs_table_gateway');
                    $dialogsTable = new \Dialogs\Model\DialogsTable($dialogsTableGateway); 
                    return $dialogsTable;
                },
                // forms
                'SendMsgForm' => function ($sm) {
                    $form = new \Dialogs\Form\SendMsgForm();
                    //$form->setInputFilter($sm->get('RegisterFormFilter'));
                    return $form;
                },
            ),
        );
    }

}