<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\Post;

class AttachmentController extends AbstractActionController {

    public function indexAction() {
        return array();
    }

    public function processAction() {
        $postId = (int) $this->params()->fromRoute(Post::POST_ID);
        $sm = $this->getServiceLocator();
        $request = $this->request;

        if (!$request->isPost()) {
            return $this->redirect()->toUrl("/post/edit/$postId");
        }

        $userId = $sm->get('logged_in_user_id');

        //save upload file
        $upload = $this->saveUpload($request);

        $uploadId = $upload->get(\Upload\Model\Upload::UPLOAD_ID);

        $attachmentTable = $sm->get("attachment_table");
        $attachmentTable->saveAttachment($userId, $postId, $uploadId);

        return $this->redirect()->toUrl('/post/edit/' . $postId);
    }

    public function saveUpload($request) {

        if ($request->isPost()) {
            $sm = $this->getServiceLocator();

            $userId = $sm->get('logged_in_user_id');
            $uploadTalbe = $sm->get('upload_table');

            $fileManager = new \Upload\Manager\UploadFileManager($uploadTalbe);
            $upload = $fileManager->saveUserFileFromRequest($userId, $request);

            return $upload;
        }
    }

    public function deleteAction() {
        $attachmentId = (int) $this->params()->fromQuery(\Post\Model\Attachment::ATTACHMENT_ID);
        $postId = (int) $this->params()->fromQuery(\Post\Model\Post::POST_ID);

        $sm = $this->getServiceLocator();

        $attachmentTable = $sm->get('attachment_table');
        $uploadFileManager = $sm->get('upload_manager');

        $attachment = $attachmentTable->getAttachmentById($attachmentId);
        $uploadId = $attachment->get('upload_id');

        $userId = $sm->get('logged_in_user_id');

        if ($userId == $attachment->get('user_id')) {
            $attachmentTable->deleteAttachmentById($attachmentId);
            $uploadFileManager->deleteUploadById($uploadId);
            return $this->redirect()->toUrl("/post/edit/$postId");
        }
        
        return $this->redirect()->toUrl("/post/edit/$postId");
    }
}
