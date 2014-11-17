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
                    $form = new \Realty\Form\RealtyForm();
                    return $form;
                },
                'Realty\Form\RealtyTypeForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyTypeForm();
                    $form->get('redirect')->setAttribute('value', '/realty/edit-contacts/');

                    $ct = $sm->get('category_table');
                    $form->get('realty_type')->setAttribute('options', $ct->getCategoryListById(79));
//                    $inputFilter = new \Post\Form\PostInputFilter();
//                    $form->setInputFilter($inputFilter);
//                    
//                    $categoryTable = $sm->get('category_table');
//                    $list = $categoryTable->getCategoryList();
//                   
//                    $form->get('category_id')->setAttribute('options', $list);

                    return $form;
                },
                'Realty\Form\RealtyContactsForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyContactsForm();
                    $form->get('redirect')->setAttribute('value', '/realty/edit-address/');
                    return $form;
                },
                'Realty\Form\RealtyAddressForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyAddressForm();
                    $form->get('redirect')->setAttribute('value', '/realty/edit-map/');
                    return $form;
                },
                 'Realty\Form\RealtyMapForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyMapForm();
                    $form->get('redirect')->setAttribute('value', '/realty/edit-flat/');
                    return $form;
                },
                'Realty\Form\RealtyFlatForm' => function ($sm) {
                    $form = new \Realty\Form\RealtyFlatForm();

                    $ct = $sm->get('category_table');
                    $form->get('type_of_repair')->setAttribute('options', $ct->getCategoryListById(68));
                    $form->get('type_of_flat')->setAttribute('options', $ct->getCategoryListById(71));

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
