<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Model\User;

class LoginController extends AbstractActionController {

    public function loginAction() {
        $sm = $this->getServiceLocator();

        $loggedInUserId = (int) $sm->get('logged_in_user_id');
        if ($loggedInUserId != 0) {
            return $this->redirect()->toUrl('/');
        }

        return array();
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/user/login');
        }

        $sm = $this->getServiceLocator();
        $sm->get('zend_auth_service')->clearIdentity();

        $post = $this->request->getPost();

        $sm->get('zend_auth_service')->getAdapter()
                ->setIdentity($post->email)
                ->setCredential(md5($post->password));

        $result = $sm->get('zend_auth_service')->authenticate();

        if ($result->isValid()) {
            $userTable = $sm->get('user_table');
            $user = $userTable->getUserByEmail($post->email);
            $sm->get('zend_auth_service')->getStorage()->write($user->get(User::USER_ID));
            return $this->redirect()->toUrl($post->redirect);
        }

        return $this->redirect()->toUrl('/user/login/error');
    }

    public function errorAction() {
        return array();
    }

    public function confirmAction() {
        return array();
    }

    public function logoutAction() {
        return $this->redirect()->toUrl('/user/login');
    }
}
