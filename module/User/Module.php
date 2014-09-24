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
                },
                'User\Form\LoginForm' => function ($sm) {
                    $form = new \User\Form\LoginForm();
                    $inputFilter = new \User\Form\LoginInputFilter();
                    $form->setInputFilter($inputFilter);
                    $form->get('redirect')->setAttribute('value', '/user/login/confirm');
                    return $form;
                },
                'User\Form\RegisterForm' => function ($sm) {
                    $form = new \User\Form\RegisterForm();
                    $inputFilter = new \User\Form\RegisterInputFilter();
                    $form->setInputFilter($inputFilter);
                    $form->get('redirect')->setAttribute('value', '/user/register/confirm');
                    return $form;
                },
            )
        );
    }
    
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'userEditWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $widget = new \User\View\Helper\UserEditWidget($sm);
                    $widget->setViewTemplate('/helper/user/edit');
                    return $widget;
                },
                'userViewWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $widget = new \User\View\Helper\UserViewWidget($sm);
                    $widget->setViewTemplate('/helper/user/view');
                    return $widget;
                },
                'userLoginWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $widget = new \User\View\Helper\UserLoginWidget($sm);
                    $widget->setViewTemplate('/helper/user/login');
                    return $widget;
                },
                'userRegisterWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $widget = new \User\View\Helper\UserRegisterWidget($sm);
                    $widget->setViewTemplate('/helper/user/register');
                    return $widget;
                },
                'userPanelWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator(); 
                    $userPanelWidget = new \User\View\Helper\UserPanelWidget($sm);
                    $userPanelWidget->setViewTemplate('/helper/user/panel');
                    return $userPanelWidget;
                },
            ),
        );
    }
}
