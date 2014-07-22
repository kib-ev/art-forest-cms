<?php

namespace Dialogs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Log\Logger;

class DialogsController extends AbstractActionController
{
    const ACTION_INDEX = '/dialog';
    const ACTION_OPEN = '/dialog/open/';
    const ACTION_LIST = '/dialog/list';

    private function getLoggedInUser()
    {
        return $this->getServiceLocator()->get('logged_in_user');
    }

    public function indexAction()
    {
        $user = $this->getLoggedInUser();
        $dialogTable = $this->getServiceLocator()->get('dialogs_table');

        return array(
            'dialogs' => $dialogTable->getDialogsByUserId($user->getId()),
            'serviceLocator' => $this->getServiceLocator()
        );
    }

    public function listAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $dialogTable = $this->getServiceLocator()->get('dialogs_table');

        return array(
            'dialogs' => $dialogTable->getDialogsByUserId($user->getId()),
            'serviceLocator' => $this->getServiceLocator()
        );
    }

    public function openAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $form = $this->getServiceLocator()->get('SendMsgForm');

        $id = $this->params()->fromRoute('id');

        Logger::info("DialogsController: user($user->user_id) open chat with user($id)");

        $userTable = $this->getServiceLocator()->get('users_table');
        $selectedUser = $userTable->getUserById($id);

        $selectedUserId = $selectedUser->user_id;



        if ($selectedUserId == $user->user_id || !isset($selectedUserId)) {
            return $this->redirect()->toUrl(DialogsController::ACTION_LIST);
        }

        $dialogTable = $this->getServiceLocator()->get('dialogs_table');
        $dialogs = $dialogTable->getDialogsForUsers($user->getId(), $selectedUserId);

        $view = new ViewModel(array(
            'selectedUserId' => $selectedUserId,
            'dialogs' => $dialogs,
        ));

        $view->setVariable('form', $form);


        return $view;
    }

    protected function getSelectedUser()
    {
        // Logger::info('protected function getSelectedUser()');

        return $selectedUser;
    }

    public function sendAction()
    {
        $sender_id = $this->getLoggedInUser()->getId();
        $recipient_id = $this->params()->fromPost('selectedUserId');
        $text = $this->params()->fromPost('text');

        $data = array(
            'sender_id' => $sender_id,
            'recipient_id' => $recipient_id,
            'text' => $text,
            'create_date' => date("Y-m-d H:i:s", strtotime('+3 hours')),
            'is_new' => true,
        );

        $dialog = new \Dialogs\Model\Dialog();
        $dialog->exchangeArray($data);

        $dialogTable = $this->getServiceLocator()->get('dialogs_table');
        $dialogTable->saveDialog($dialog);

        return $this->redirect()->toUrl(
                        DialogsController::ACTION_OPEN .
                        $recipient_id);
    }

    public function ajaxSendAction()
    {
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
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));

        return $response;
    }

    public function deleteAction()
    {
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