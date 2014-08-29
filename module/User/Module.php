<?php

namespace User;

class Module {

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
                'zend_auth_service' => function ($sm) {
                    $dbAdapter = $sm->get('zend_db_adapter');
                    $dbTableAuthAdapter = new \Zend\Authentication\Adapter\DbTable($dbAdapter, 'user', 'email', 'password', ''); // md5(?)
                    $authService = new \Zend\Authentication\AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                'logged_in_user_id' => function ($sm) {
                    $authService = $sm->get('zend_auth_service');
                    $userId = $authService->getStorage()->read();
                    return isset($userId) ? $userId : 0;
                },
                'user_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('zend_db_adapter');
                    $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
                    $user = new \User\Model\User();
                    $resultSetPrototype->setArrayObjectPrototype($user);
                    $userTableGateway = new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                    return $userTableGateway;
                },
                'user_table' => function ($sm) {
                    $userTableGateway = $sm->get('user_table_gateway');
                    $userTable = new \User\Model\UserTable($userTableGateway);
                    return $userTable;
                }
            )
        );
    }
    
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'userEditWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $userEditWidget = new \User\View\Helper\UserEditWidget($sm);
                    $userEditWidget->setViewTemplate('/helper/user/edit');
                    return $userEditWidget;
                },
                'userViewWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $userViewWidget = new \User\View\Helper\UserViewWidget($sm);
                    $userViewWidget->setViewTemplate('/helper/user/view');
                    return $userViewWidget;
                },
            ),
        );
    }
}
