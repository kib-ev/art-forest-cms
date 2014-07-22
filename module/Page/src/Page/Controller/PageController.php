<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Page\Form\FeedbackForm;

class PageController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toUrl('/page/list');
    }

    public function listAction()
    {
        return array();
    }

    public function addAction()
    {
        return array();
    }

    public function upAction()
    {
        return array();
    }

    public function editAction()
    {
        return array('url' => $this->params()->fromRoute('url'));
    }

    public function viewAction()
    {
        return array('url' => $this->params()->fromRoute('url'));
    }

    public function deleteAction()
    {
        $url = $this->params()->fromRoute('url');

        $pageTable = $this->getServiceLocator()->get('page_table');
        $page = $pageTable->getPageByUrl($url);

        $pageTable->deletePageById($page->id);
        return $this->redirect()->toUrl('/page/index');
    }

    public function processAction()
    {
        $data['user_id'] = $this->getServiceLocator()->get('logged_in_user')->getId();

        $data['create_date'] = date("Y-m-d H:i:s");
        $data['id'] = $this->request->getPost('id');
        $data['url'] = $this->request->getPost('url');
        $data['title'] = $this->request->getPost('title');
        $data['index'] = $this->request->getPost('index');
        $data['body'] = $this->request->getPost('body');

        $newPage = new \Page\Model\Page();
        $newPage->exchangeArray($data);

        $pageTable = $this->getServiceLocator()->get('page_table');

        $pageTable->savePage($newPage);
        $url = $newPage->url;
        return $this->redirect()->toUrl("/page/view/$url");
    }

    public function jsonFeedbackAction()
    {
        $request = $this->getRequest();
        $data = $post = $request->getPost();
        \Application\Log\Logger::info('jsonFeedbackAction' . $post->name . $post->contacts . $post->message);
        $feedbackForm = new FeedbackForm();

        $htmlBody = "<p>Имя: <br/>$post->name<br/>Контакты: <br/>$post->contacts<br/>Сообщение: <br/>$post->message</p>";

        $feedbackForm->bind($data);

        if ($feedbackForm->isValid()) {
            $this->sendMail($htmlBody);
            $answer = array('status' => 'ok');
        } else {
            $answer = array('status' => 'bad');
        }


        return new \Zend\View\Model\JsonModel($answer);
    }

    protected function sendMail($htmlBody)
    {
        $options = new \Zend\Mail\Transport\SmtpOptions(array(
            "name" => "atservers",
            "host" => "ox20m.atservers.net",
            "port" => 587,
            "connection_class" => "login",
            "connection_config" => array("username" => "no-reply@ardfo.by",
                "password" => "KxKL>e1+0.")
        ));

        $html = new \Zend\Mime\Part($htmlBody);
        $html->type = "text/html";
        $body = new \Zend\Mime\Message();
        $body->setParts(array($html,));

        $mail = new \Zend\Mail\Message();
        $mail->setEncoding("UTF-8");

        $toMail = 'feedback@ardfo.by';
        $toName = 'admin';
        $subject = 'feedback';

        $mail->setBody($body);
        $mail->setFrom('no-reply@ardfo.by', 'www.ardfo.by');
        $mail->addTo($toMail, $toName);
        $mail->setSubject($subject);
        $transport = new \Zend\Mail\Transport\Smtp();
        $transport->setOptions($options);
        $transport->send($mail);
    }

}