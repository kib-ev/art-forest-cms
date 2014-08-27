<?php

namespace Post\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Post\Model\Attachment;

class AddAttachmentWidget extends AbstractHelper {

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    protected $userId;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($postId) {
        $sm = $this->sm;
        $attachmentTable = $sm->get('attachment_table');
        $attachments = $attachmentTable->getAttachmentsByPostId($postId);

        $uploadTable = $sm->get('upload_table');
        $uploads = array();
        foreach ($attachments as $attachment) {
            $uploadId = $attachment->get(Attachment::UPLOAD_ID);
            $upload = $uploadTable->getUploadById($uploadId);
            array_push($uploads, $upload);
        }

        $form = new \Upload\Form\UploadForm();

        $view = new \Zend\View\Model\ViewModel(
                array(
            'uploads' => $uploads,
            'form' => $form,
            'postId' => $postId,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
