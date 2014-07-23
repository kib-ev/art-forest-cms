<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\User;

class RegisterController extends AbstractActionController {
    const PHYSICAL_REG_TYPE = 1;
    const INDIVIDUAL_REG_TYPE = 2;
    const LEGAL_REG_TYPE = 3;
    const INDEX_ACTION = '/users/register';
    const CONFIRM_ACTION = '/users/register/confirm';

    protected $authservice;
    protected $userTable;

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('zend_auth_service');
        }
        return $this->authservice;
    }

    public function getUserTable() {
        if (!$this->userTable) {
            $this->userTable = $this->getServiceLocator()->get('users_table');
        }
        return $this->userTable;
    }
    /* регистрация юридичских лиц */

    public function legalAction() {
        $authService = $this->getServiceLocator()->get('zend_auth_service');
        $authService->clearIdentity();

        $form = new \Users\Form\Register\Legal();
        $view = new ViewModel(array('form' => $form));
        return $view;
    }
    /* регистрация физических лиц */

    public function physicalAction() {
        $authService = $this->getServiceLocator()->get('zend_auth_service');
        $authService->clearIdentity();

        $form = new \Users\Form\Register\Physical();
        $view = new ViewModel(array('form' => $form));
        return $view;
    }
    /* регистрация ИП */

    public function individualAction() {
        $authService = $this->getServiceLocator()->get('zend_auth_service');
        $authService->clearIdentity();

        $form = new \Users\Form\Register\Individual();
        $view = new ViewModel(array('form' => $form));
        return $view;
    }

    public function legalProcessAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array(
                        'controller' => 'register',
                        'action' => 'index',
            ));
        }

        $post = $this->request->getPost();
        $form = new \Users\Form\Register\Legal();
        $form->setInputFilter(new \Users\Form\Register\Filter\Legal());
        $form->setData($post);

        if (!$form->isValid()) {
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('form', $form);

            $view->setTemplate('users/register/legal');

            return $view;
        }

        $data = $form->getData();
        $data['reg_type'] = RegisterController::LEGAL_REG_TYPE;
        $data['state'] = User::STATE_NOT_ACTIVATED;
        $data['create_date'] = \Users\DateTime\DateTime::getCurrentDateTimeString();
        $data['off_date'] = \Users\DateTime\DateTime::getCurrentDateTimeString();
        $data['display_name'] = $data['org_name'];

        if (!$this->createUser($data)) {
            $form->bind($post);
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('message', 'Данный email уже зарегистрирован');
            $view->setVariable('form', $form);
            $view->setTemplate('users/register/legal');

            return $view;
        }
        $sm = $this->getServiceLocator();
// Автоматическая аутентификация
        $isAuth = $this->authenticate($sm, $post);
        $this->sendMail($post, 'email/tpl/fiz');

        if ($isAuth) {

            $id = $sm->get('logged_in_user')->user_id;
            return $this->redirect()->toRoute('post', array(
                        'controller' => 'post',
                        'action' => 'list',
                        'id' => $id,
            ));
        }
        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'register',
                    'action' => 'confirm',
        ));
    }

    public function individualProcessAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl(RegisterController::INDEX_ACTION);
        }

        $post = $this->request->getPost();
        $form = new \Users\Form\Register\Individual();
        $form->setInputFilter(new \Users\Form\Register\Filter\Individual());
        $form->setData($post);

        if (!$form->isValid()) {
            $view = new ViewModel();
            $view->setVariable('error', true);
            $view->setVariable('form', $form);

            $view->setTemplate('users/register/individual');

            return $view;
        }

        $data = $form->getData();
        $data['reg_type'] = RegisterController::INDIVIDUAL_REG_TYPE;
        $data['state'] = User::STATE_NOT_ACTIVATED;
        $data['create_date'] = \Users\DateTime\DateTime::getCurrentDateTimeString();
        $data['off_date'] = \Users\DateTime\DateTime::getCurrentDateTimeString();
        $data['display_name'] = $data['org_name'];

        if (!$this->createUser($data)) {
            $form->bind($post);
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('message', 'Данный email уже зарегистрирован');
            $view->setVariable('form', $form);
            $view->setTemplate('users/register/individual');

            return $view;
        }
        $sm = $this->getServiceLocator();
// Автоматическая аутентификация
        $isAuth = $this->authenticate($sm, $post);
        $this->sendMail($post, 'email/tpl/fiz');

        if ($isAuth) {

            $id = $sm->get('logged_in_user')->user_id;
            return $this->redirect()->toRoute('post', array(
                        'controller' => 'post',
                        'action' => 'list',
                        'id' => $id,
            ));
        }
        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'register',
                    'action' => 'confirm',
        ));
    }

    public function physicalProcessAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl(RegisterController::INDEX_ACTION);
        }

        $post = $this->request->getPost();
        $form = new \Users\Form\Register\Physical();
        $form->setInputFilter(new \Users\Form\Register\Filter\Physical());
        $form->setData($post);

        if (!$form->isValid()) {

            $form->bind($post);
            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('form', $form);
            $view->setTemplate('users/register/physical');

            return $view;
        }

        $data = $form->getData();
        $data['reg_type'] = RegisterController::PHYSICAL_REG_TYPE;
        $data['state'] = User::STATE_ACTIVATED;
        $data['create_date'] = \Users\DateTime\DateTime::getCurrentDateTimeString();
        $data['off_date'] = \Users\DateTime\DateTime::getMaxDateTimeString();
        $data['display_name'] = $data['org_name'];


        if (!$this->createUser($data)) {

            $view = new ViewModel();

            $view->setVariable('error', true);
            $view->setVariable('message', 'Данный email уже зарегистрирован');
            $view->setVariable('form', $form);
            $view->setTemplate('users/register/physical');

            return $view;
        }

        $sm = $this->getServiceLocator();
        // Автоматическая аутентификация
        $isAuth = $this->authenticate($sm, $post);
        // Отправка e-mail
        $this->sendMail($post, 'email/tpl/fiz');

        if ($isAuth) {

            $id = $sm->get('logged_in_user')->user_id;
            return $this->redirect()->toRoute('post', array(
                        'controller' => 'post',
                        'action' => 'list',
                        'id' => $id,
            ));
        }
        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'register',
                    'action' => 'confirm',
        ));
    }

    protected function createUser(array $data) {

        if (!$this->isUserExists($data['email'])) {

            $data['role_id'] = 2; //todo magic


            $user = new User();
            $user->exchangeArray($data);

            $userTable = $this->getServiceLocator()->get('users_table');
            $userTable->saveUser($user);

            return true;
        } else {
            return false;
        }
    }

    protected function isUserExists($email) {
        $user = $this->getUserTable()->getUserByEmail($email);
        return $user ? true : false;
    }

    public function confirmAction() {
        return array();
    }

    public function authenticate($sm, $post) {
        $form = $sm->get('LoginForm');
        $form->setData($post);

        if ($form->isValid()) {
            $sm->get('zend_auth_service')->getAdapter()
                    ->setIdentity($post->email)
                    ->setCredential($post->password);

            $result = $sm->get('zend_auth_service')->authenticate();

            if ($result->isValid()) {
                $usersTable = $sm->get('users_table');
                $user = $usersTable->getUserByEmail($this->request->getPost('email'));

                $sm->get('zend_auth_service')->getStorage()->write($user);

                $loggedInUser = $sm->get('logged_in_user'); //temp
                $usersTable->updateUserClearPassword($loggedInUser->user_id, $post->password); //temp

                return true;
            }
        }
    }

    public function sendMail($post, $template) {
        $options = new \Zend\Mail\Transport\SmtpOptions(array(
            "name" => "atservers",
            "host" => "ox20m.atservers.net",
            "port" => 587,
            "connection_class" => "login",
            "connection_config" => array("username" => "no-reply@ardfo.by",
                "password" => "KxKL>e1+0.")
        ));


        $name = $post->last_name . ' ' . $post->first_name;

        $this->renderer = $this->getServiceLocator()->get('ViewRenderer');
        $content = $this->renderer->render($template, array(
            'name' => $name,
            'login' => $post->email,
            'password' => $post->password,
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

        $toMail = $post->email;
        $toName = $name;
        $subject = 'Спасибо за регистрацию на сайте ardfo.by';

        $mail->setBody($body);
        $mail->setFrom('no-reply@ardfo.by', 'www.ardfo.by');
        $mail->addTo($toMail, $toName);
        $mail->setSubject($subject);
        $transport = new \Zend\Mail\Transport\Smtp();
        $transport->setOptions($options);
        $transport->send($mail);
    }
}
