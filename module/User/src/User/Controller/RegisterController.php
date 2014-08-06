<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RegisterController extends AbstractActionController {

    public function registerAction() {
        $form = new \User\Form\RegisterForm();
        $inputFilter = new \User\Form\RegisterInputFilter();
        $form->setInputFilter($inputFilter);

        return array('form' => $form);
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/user/register');
        }

        $sm = $this->getServiceLocator();
        $sm->get('zend_auth_service')->clearIdentity();

        $post = $this->request->getPost();

        $data = array(
            'email' => $post->email,
            'password' => $post->password,
            'createDate' => time(),
        );

        $form = new \User\Form\RegisterForm();
        $form->setInputFilter(new \User\Form\RegisterInputFilter());
        $form->setData($data);

        if (!$form->isValid()) {
            $view = new \Zend\View\Model\ViewModel();
            $view->setTemplate('/user/register/register');
            $view->setVariable('form', $form);
            return $view;
        }

        $user = new \User\Model\User($data);
        $userTable = $sm->get('user_table');
        $userTable->saveUser($user);

        return $this->redirect()->toUrl('/user/register/confirm');
    }

    public function errorAction() {
        return array();
    }

    public function confirmAction() {
        return array();
    }
}
