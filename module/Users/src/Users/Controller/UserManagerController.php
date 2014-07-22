<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

//use Users\Model\UserTable;
//use Users\Model\User;

class UserManagerController extends AbstractActionController {

    public function indexAction() {
        $userTable = $this->getServiceLocator()->get('users_table');
        $view = new ViewModel();
        $view->setTemplate('users\user-manager\index');
        $view->setVariable('users', $userTable->fetchAll());
        return $view;
    }

    public function editAction() {
        $userTable = $this->getServiceLocator()->get('users_table');
        $userId = $this->params()->fromRoute('id');

        $user = $userTable->getUser($userId);

        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);

        $view = new ViewModel(array(
            'form' => $form,
            'user_id' => $userId,
        ));
        $view->setTemplate('users\user-manager\edit');

        return $view;
    }

    public function processAction() {
        $post = $this->request->getPost();
        $userTable = $this->getServiceLocator()->get('users_table');

        $user = $userTable->getUser($post->user_id);

        $form = $this->getServiceLocator()->get('UserEditForm');

        $form->bind($user);
        $form->setData($post);
        
        if (!$form->isValid()) {
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('form', $form);

            $view->setTemplate("users/user-manager/edit");
            return $view;
        }

        $userTable->saveUser($user);

        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'user-manager',
                    'action' => 'index',
        ));
    }

    public function deleteAction() {
        $userId = $this->params()->fromRoute('id');
        
        if (!$userId) {
            echo "error";
        }

        $userTable = $this->getServiceLocator()->get('users_table');
        $userTable->deleteUser($userId);

        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'user-manager',
                    'action' => 'index',
        ));
    }

}
