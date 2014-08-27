<?php

namespace Dialog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Log\Logger;

class DialogController extends AbstractActionController {

    const ROUTE_INDEX = '/dialog';
    const ROUTE_OPEN = '/dialog/open/';
    const ROUTE_LIST = '/dialog/list';

    private function getLoggedInUser() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');
        $userTable = $sm->get('user_table');
        $user = $userTable->getUserById($userId);
        return $user;
    }

    public function indexAction() {
        return $this->redirect()->toUrl(static::ROUTE_LIST);
    }

    public function openAction() {
        $sm = $this->getServiceLocator();

        $selectedUserId = (int) $this->params()->fromQuery('user_id');
//        if (!$this->isUserExists($selectedUserId)) {
//            return $this->redirect()->toUrl(static::ROUTE_LIST);
//        }

        $currentUserId = $sm->get('logged_in_user_id');

        return array(
            'currentUserId' => $currentUserId,
            'selectedUserId' => $selectedUserId,
        );
    }

    public function isUserExists($selectedUserId) {
        if ($selectedUserId == 0) {
            return false;
        }

        $sm = $this->getServiceLocator();
        $userTable = $sm->get('user_table');
        $user = $userTable->getUserById($selectedUserId);

        return empty($user) ? false : true;
    }

    public function listAction() {
        $dialogTable = $this->getServiceLocator()->get('dialog_table');

        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');
        
        $dialogs = $dialogTable->getDialogsByUserId($userId);
        
        return array(
            'currentUserId' => $userId,
            'dialogs' => $dialogs,
        );
    }

    protected function getSelectedUser() {
        // Logger::info('protected function getSelectedUser()');


        return $selectedUser;
    }

    public function processAction() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $sender_id = $this->params()->fromPost('sender_id');
        $recipient_id = $this->params()->fromPost('recipient_id');
        $message = $this->params()->fromPost('message');


        $form = new \Dialog\Form\DialogForm();
        $inputFilter = new \Dialog\Form\DialogInputFilter();
        $form->setInputFilter($inputFilter);


        if ($sender_id != $userId) {
            \Application\Log\Logger::warn("user $userId change html in dialog form");
            return $this->redirect()->toUrl("/dialog/open/?user_id=$recipient_id");
        }

        $data = array(
            'sender_id' => $sender_id,
            'recipient_id' => $recipient_id,
            'message' => $message,
            'create_date' => time(),
            'is_unread' => true,
        );

        $form->setData($data);

        if (!$form->isValid()) {
            $formMessages = $form->getMessages();
            $this->flashMessenger()->setNamespace($form->getName())->addMessage($formMessages);
            return $this->redirect()->toUrl("/dialog/open/?user_id=$recipient_id");
        }

        $dialog = new \Dialog\Model\Dialog($data);

        $dialogTable = $sm->get('dialog_table');
        $dialogTable->saveDialog($dialog);

        return $this->redirect()->toUrl("/dialog/open/?user_id=$recipient_id");
    }

    public function ajaxSendAction() {
        if (!$this->request->isXmlHttpRequest()) {
            return $this->redirect()->toUrl('/dialog');
        }

        $currentUserId = $this->getLoggedInUser()->getId();
        $selectedUserId = $this->request->getPost('selectedUserId');
        $text = $this->request->getPost('text');

        if (!empty($text) && !empty($selectedUserId)) {
            $data = array(
                'sender_id' => $currentUserId,
                'recipient_id' => $currentUserId,
                'text' => $text,
                'create_date' => date("Y-m-d H:i:s", strtotime('+3 hours')),
                'is_new' => true,
            );

            $dialog = new \Dialogs\Model\Dialog();
            $dialog->exchangeArray($data);

            $dialogTable = $this->getServiceLocator()->get('dialogs_table');
            $dialogTable->saveDialog($dialog);

            // ajax response
            $answer = array(
                'status' => 'ok',
                'text' => $text,
            );
        }

        $response = $this->getResponse();
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json'));

        return $response;
    }

    public function deleteAction() {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $currentUserId = $this->getLoggedInUser()->getId();
        $selectedUserId = $this->params()->fromRoute('id');

        $dialogTable = $this->getServiceLocator()->get('dialogs_table');
        $dialogTable->deleteUsersDialogs($currentUserId, $selectedUserId);


        return $this->redirect()->toUrl(DialogsController::ACTION_LIST);
    }
}
