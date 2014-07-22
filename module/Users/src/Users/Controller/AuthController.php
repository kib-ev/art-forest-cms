<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\DateTime\DateTime as DT;
use Users\Model\RestoreEntity;

class AuthController extends AbstractActionController
{
    const LOGIN = '/users/auth/login';
    const LOGOUT_ACTION = '/users/auth/logout';
    const CONFIRM_ACTION = '/users/auth/confirm';

    protected $authservice;

    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('zend_auth_service');
        }
        return $this->authservice;
    }

    public function indexAction()
    {
        return $this->redirect()->toUrl(AuthController::LOGIN);
    }

    public function loginAction()
    {
        $authService = $this->getServiceLocator()->get('zend_auth_service');
        $authService->clearIdentity();

        $form = $this->getServiceLocator()->get('LoginForm');
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }

    public function processAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl(AuthController::LOGIN);
        }
        // get data from request
        $post = $this->request->getPost();
        $sm = $this->getServiceLocator();
        return $this->authenticate($sm, $post);
    }

    public function confirmAction()
    {
        return $this->redirect()->toUrl('/');
    }

    public function logoutAction()
    {
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toUrl('/');
    }

    public function forgotAction()
    {
        return array();
    }

    public function forgotProcessAction()
    {
        $post = $this->request->getPost();
        $email = $post->email;

        $userTable = $this->getServiceLocator()->get('users_table');
        $user = $userTable->getUserByEmail($email);

        $view = new ViewModel();
        $view->setVariable('form', new \Users\Form\LoginForm());
        $view->setTemplate('/users/auth/login');

        if ($user) {
            $restoreEntity = $this->createRestoreEntity($user);
            $this->sendEmail($user, $restoreEntity);
            $view->setVariable('message', 'На указанный вами Email отправлено письмо');
        }

        return $view;
    }

    const LINK_LIVETIME = '+2 hours';

    public function createRestoreEntity($user)
    {
        $restoreTable = $this->getServiceLocator()->get('restore_table');

        $restoreEntity = $restoreTable->getRestoreEntityByUserId($user->user_id);
        if (empty($restoreEntity)) {
            $restoreEntity = new \Users\Model\RestoreEntity();
        }

        $currentDateTime = DT::getCurrentDateTime();
        $offDateTime = date_modify(DT::getCurrentDateTime(), AuthController::LINK_LIVETIME);

        $restoreEntity->createDate = DT::getDateTimeString($currentDateTime);
        $restoreEntity->offDate = DT::getDateTimeString($offDateTime);
        $restoreEntity->userId = $user->user_id;
        $restoreEntity->key = md5(rand(100000, 999999)) . md5(rand(100000, 999999)) . md5(rand(100000, 999999)); 

        $restoreTable->saveRestoreEntity($restoreEntity);

        return $restoreEntity;
    }

    public function changeAction()
    {
        if (isset($_GET['key'])) {
            $key = $_GET['key'];

            $restoreTable = $this->getServiceLocator()->get('restore_table');
            $restoreEntity = $restoreTable->getRestoreEntityByKey($key);

            if (!empty($restoreEntity)) {

                $currentDate = DT::getCurrentDateTime();
                $offDate = new \DateTime($restoreEntity->offDate);

                $intCurrDate = (int) $currentDate->getTimestamp();
                $intOffDate = (int) $offDate->getTimestamp();

                if ($intOffDate > $intCurrDate) {
                    return array(
                        'userId' => $restoreEntity->userId,
                        'key' => $key);
                }
            }
        }
        return array();
    }

    public function changeProcessAction()
    {
        $key = $this->request->getPost()->key;
        $userId = $this->request->getPost()->userId;
        $newPassword = $this->request->getPost()->newPassword;
        // todo form


        $restoreTable = $this->getServiceLocator()->get('restore_table');
        $restoreEntity = $restoreTable->getRestoreEntityByKey($key);

        if (!empty($restoreEntity)) {
            // update offDate
            $currentDate = DT::getCurrentDateTime();
            $restoreEntity->offDate = DT::getDateTimeString($currentDate);
            $restoreTable->saveRestoreEntity($restoreEntity);
        }

        if (!empty($restoreEntity) && ($restoreEntity->userId == $userId)) {
            // update user password
            $userTable = $this->getServiceLocator()->get('users_table');
            $user = $userTable->getUserById($userId);
            $user->password = md5($newPassword);
            $userTable->saveUser($user);
        }
        return $this->redirect()->toUrl(AuthController::LOGIN);
    }

    public function authenticate($sm, $post)
    {
        $form = $sm->get('LoginForm');
        $form->setData($post);

        if (!$form->isValid()) {
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('form', $form);

            $view->setTemplate('users\auth\login');

            return $view;
        } else {

            //check authentication...

            $sm->get('zend_auth_service')->getAdapter()
                    ->setIdentity($post->email)
                    ->setCredential($post->password);

            $result = $sm->get('zend_auth_service')->authenticate();

            if ($result->isValid()) {

                $usersTable = $sm->get('users_table');
                $user = $usersTable->getUserByEmail($this->request->getPost('email'));

                $sm->get('zend_auth_service')->getStorage()->write($user);

                if (!$sm->get('is_activated')) { //temp
                    return $this->redirect()->toUrl('/users/activate');
                }

                return $this->redirect()->toUrl(AuthController::CONFIRM_ACTION);
            } else {
                $model = new ViewModel(array(
                    'error' => true,
                    'form' => $form,
                ));
                $model->setTemplate('users/auth/login');
                return $model;
            }
        }
    }

    protected function sendEmail($user, RestoreEntity $restoreEntity)
    {
        $options = new \Zend\Mail\Transport\SmtpOptions(array(
            "name" => "atservers",
            "host" => "ox20m.atservers.net",
            "port" => 587,
            "connection_class" => "login",
            "connection_config" => array("username" => "no-reply@ardfo.by",
                "password" => "KxKL>e1+0.")
        ));

        $this->renderer = $this->getServiceLocator()->get('ViewRenderer');
        $content = $this->renderer->render('email/tpl/forgot', array(
            'email' => $user->email,
            'restoreLink' => 'http://' . $_SERVER['SERVER_NAME'] . '/users/auth/change?key=' . $restoreEntity->key,
            'offDate' => $restoreEntity->offDate,
        ));

        // make a header as html  
        $html = new \Zend\Mime\Part($content);
        $html->type = "text/html";
        $body = new \Zend\Mime\Message();
        $body->setParts(array($html,));

        $mail = new \Zend\Mail\Message();
        $mail->setEncoding("UTF-8");

        $headers = $mail->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');


        $toMail = $user->email;
        $toName = $user->last_name . ' ' . $user->first_name;
        $subject = 'Восстановление пароля на сайте ardfo.by';

        $mail->setBody($body);
        $mail->setFrom('no-reply@ardfo.by', 'www.ardfo.by');
        $mail->addTo($toMail, $toName);
        $mail->setSubject($subject);
        $transport = new \Zend\Mail\Transport\Smtp();
        $transport->setOptions($options);
        $transport->send($mail);
    }

}