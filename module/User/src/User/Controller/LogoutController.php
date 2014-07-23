<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LogoutController extends AbstractActionController {

    public function logoutAction() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');
        if ($userId == 0) {
            return $this->redirect()->toUrl('/user/logout/error');
        } else {
            $sm->get('zend_auth_service')->clearIdentity();
            return $this->redirect()->toUrl('/user/logout/confirm');
        }
    }

    public function confirmAction() {
        return array();
    }

    public function errorAction() {
        return array();
    }
}
