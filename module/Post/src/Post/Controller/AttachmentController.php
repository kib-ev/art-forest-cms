<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AttachmentController extends AbstractActionController {

    public function indexAction() {
        return array();
    }
    
    public function deleteAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            $attachmentTable->deleteAttachment($postData->upload_id);
            $status = $uploadfilemanager->deleteFile($postData->upload_id);
        }
        $answer = array('status' => $status);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));

        return $response;
    }
}