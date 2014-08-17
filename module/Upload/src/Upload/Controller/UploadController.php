<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Upload\Model\Upload;
use Zend\Validator\File\Size;

class UploadController extends AbstractActionController {

    public function indexAction() {
        $sm = $this->getServiceLocator();

        $uploadsTable = $sm->get('upload_table');
        $userId = $sm->get('logged_in_user_id');
        return array('uploads' => $uploadsTable->getUploadsByUserId($userId));
    }

    public function addAction() {
        return array('form' => new \Upload\Form\UploadForm());
    }

    public function processAction() {
        $request = $this->getRequest();

        $form = new \Upload\Form\UploadForm();
        $inputFilter = new \Upload\Form\UploadInputFilter();
        $form->setInputFilter($inputFilter);

        // zf2 file validation fix
        $data = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

        if (!$data['file']['tmp_name']) {
            $data['file'] = null;
        }
        //-------------------------

        $form->setData($data);
        if ($form->isValid()) {
            $this->saveUpload($request);
            return $this->redirect()->toUrl("/upload/");
        } else {
            $view = new ViewModel();
            $view->setTemplate('/upload/upload/add');
            $view->setVariable('form', $form);
            return $view;
        }
    }

    public function saveUpload($request) {
        if ($request->isPost()) {
            $sm = $this->getServiceLocator();

            $userId = $sm->get('logged_in_user_id');
            $uploadTalbe = $sm->get('upload_table');
            $ufm = new \Upload\Manager\UploadFileManager($uploadTalbe);

            $ufm->saveUserFileFromRequest($userId, $request);
        }
    }

    public function deleteAction() {
        $sm = $this->getServiceLocator();

        $uploadId = (int) $this->params()->fromRoute('upload_id');
        $userId = $sm->get('logged_in_user_id');
        $uploadTable = $sm->get('upload_table');
        $upload = $uploadTable->getUploadById($uploadId);

        if (empty($upload)) {
            $this->getResponse()->setStatusCode(404);
            return;
        } else if ($upload->get('user_id') != $userId) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $uploadTable->deleteUploadById($uploadId);
        $uploadPath = $upload->get('path');
        if (file_exists($uploadPath)) {
            unlink($uploadPath);
        }

        return $this->redirect()->toUrl("/upload/");
    }
}
