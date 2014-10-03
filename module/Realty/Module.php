<?php

namespace Realty;

class Module {

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
                'realty_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
                    $realty = new \Realty\Model\Realty();
                    $resultSetPrototype->setArrayObjectPrototype($realty);
                    $realtyTableGateway = new \Zend\Db\TableGateway\TableGateway('realty', $dbAdapter, null, $resultSetPrototype);
                    return $realtyTableGateway;
                },
                'realty_table' => function ($sm) {
                    $realtyTableGateway = $sm->get('realty_table_gateway');
                    $realtyTable = new \Realty\Model\RealtyTable($realtyTableGateway);
                    return $realtyTable;
                },
                'Realty\Form\RealtyForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyFormStep1();

//                    $inputFilter = new \Post\Form\PostInputFilter();
//                    $form->setInputFilter($inputFilter);
//                    
//                    $categoryTable = $sm->get('category_table');
//                    $list = $categoryTable->getCategoryList();
//                   
//                    $form->get('category_id')->setAttribute('options', $list);

                    return $form;
                },
                'Realty\Form\RealtyFormStep2' => function ($sm) {
                    $form = new \Realty\Form\RealtyFormStep2();
                    return $form;
                },
                'Realty\Form\RealtyFormStep3' => function ($sm) {
                    $form = new \Realty\Form\RealtyFormStep3();
                    return $form;
                },
                'Realty\Form\RealtyFormStep4Flat' => function ($sm) {
                    $form = new \Realty\Form\RealtyFormStep4Flat();
                    return $form;
                },        
                        
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
            ),
        );
    }

}
