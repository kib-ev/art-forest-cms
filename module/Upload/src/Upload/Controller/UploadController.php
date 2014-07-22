<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Upload\Model\Upload;
use Zend\Validator\File\Size;

class UploadController extends AbstractActionController {

    public function indexAction() {
        $uploadsTable = $this->getServiceLocator()->get('uploads_table');

        return array('uploads' => $uploadsTable->getUploadsByUserId(1));
    }

    public function addAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        }
        return array();
    }

    public function deleteAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
            $status = $uploadfilemanager->deleteFile($id);
        }
        $answer = array('status' => $status);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));

        return $response;
    }

}
