<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LogoutController extends AbstractActionController {

    public function logoutAction() {
        $this->getServiceLocator()->get('zend_auth_service')->clearIdentity();
        return $this->redirect()->toUrl('/user/login');
    }
}
