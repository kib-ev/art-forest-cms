<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController {

    public function indexAction() {
        return array();
    }

    public function editAction() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        return array(
            'currentUserId' => $userId,
        );
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/user/register');
        }

        $sm = $this->getServiceLocator();
        $post = $this->request->getPost();
        $form = new \User\Form\UserEditForm();

        $userId = $sm->get('logged_in_user_id');

        $data = $post->getArrayCopy();
        $form->setData($data);
        if (!$form->isValid()) { //todo
//            $view = new \Zend\View\Model\ViewModel();
//            $view->setTemplate('/user/register/register');
//            $view->setVariable('form', $form);
//            return $view;
        }

        unset($data[\User\Model\User::USER_ID]);
        unset($data[\User\Model\User::EMAIL]);

        $userTable = $sm->get('user_table');
        $user = $userTable->getUserById($userId);
        $user->exchangeArray($data);
        $userTable->saveUser($user);

        return $this->redirect()->toUrl('/user/info/edit');
    }
}
