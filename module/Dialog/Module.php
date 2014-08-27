<?php

namespace Dialog;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'dialog_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('zend_db_adapter');
                    $resultSetPrototype = new ResultSet();
                    $dialog = new \Dialog\Model\Dialog();
                    $resultSetPrototype->setArrayObjectPrototype($dialog);
                    $dialogTableGateway = new TableGateway('dialog', $dbAdapter, null, $resultSetPrototype);
                    return $dialogTableGateway;
                },
                'dialog_table' => function ($sm) {
                    $dialogTableGateway = $sm->get('dialog_table_gateway');
                    $dialogTable = new \Dialog\Model\DialogTable($dialogTableGateway);
                    return $dialogTable;
                },
                // forms
                'SendMsgForm' => function ($sm) {
                    $form = new \Dialog\Form\SendMsgForm();
                    //$form->setInputFilter($sm->get('RegisterFormFilter'));
                    return $form;
                },
            ),
        );
    }
     
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'dialogInputFormWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $dialogFormWidget = new \Dialog\View\Helper\DialogInputFormWidget($sm);
                    $dialogFormWidget->setViewTemplate('/helper/dialog/add');
                    return $dialogFormWidget;
                },
                'dialogHistoryWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $dialogHistoryWidget = new \Dialog\View\Helper\DialogHistoryWidget($sm);
                    $dialogHistoryWidget->setViewTemplate('/helper/dialog/history');
                    return $dialogHistoryWidget;
                },
            ),
        );
    }
}
