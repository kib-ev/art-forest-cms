<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RegisterController extends AbstractActionController {

    public function registerAction() {
        return array();
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/user/register');
        }

        $post = $this->request->getPost();

        $data = array(
            'email' => $post->email,
            'password' => $post->password,
            'createDate' => time(),
        );

        if (true) {
            $user = new \User\Model\User();
            $user->exchangeArray($data);

            $sm = $this->getServiceLocator();
            $userTable = $sm->get('user_table');
            $userTable->saveUser($user);

            return $this->redirect()->toUrl('/user/register/confirm');
        }

        return $this->redirect()->toUrl('/user/register/error');
    }

    public function errorAction() {
        return array();
    }

    public function confirmAction() {
        return array();
    }
}
