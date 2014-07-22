<?php

namespace Upload\Manager;

use Upload\Model\Upload;

class UploadFileManager {

    protected $uploadsTable;

    public function __construct(\Upload\Model\UploadTable $uploadsTable) {

        $this->uploadsTable = $uploadsTable;
    }

    //save files
    public function saveFiles($request, $userId) {
        $ds = DIRECTORY_SEPARATOR;

        // create dir md5 user_id if not exist
        if (!is_dir('public' . $ds . 'uploads')) {
            mkdir('public' . $ds . 'uploads');
        }

        if (!empty($_FILES)) {
            $files = $request->getFiles()->toArray();

            foreach ($files['file'] as $file) {
                $md5UserId = md5($userId);
                $pathdir = 'public' . $ds . 'uploads' . $ds . $md5UserId . $ds;
                if (!is_dir($pathdir)) {
                    mkdir($pathdir);
                }
                $ext = substr($file['name'], strpos($file['name'], '.'));
                $filename = $file['name'];
                $md5Filename = md5($filename . rand(0, 9999)) . $ext;
                $fullFilename = $pathdir . $md5Filename;

                /* validator's
                  $size = new Size(array('min'=>200));
                  $extention = new \Zend\Validator\File\Extension(array('jpg'), true);
                  $isimage = new \Zend\Validator\File\IsImage();
                  $validator = new \Zend\Validator\File\MimeType(array('image', 'audio'));
                  $adapter = new \Zend\File\Transfer\Adapter\Http();
                  $adapter->setValidators(array($validator), $files['file']['name']);
                  if ($adapter->isValid()){
                  } */

                move_uploaded_file($file['tmp_name'], $fullFilename);

                //save file information in db
                $upload = new Upload();
                $upload->setFilename($filename);
                $upload->setFilepath('http://' . $_SERVER['SERVER_NAME'] . '/uploads' .
                        '/' . $md5UserId . '/' . $md5Filename);
                $upload->setFullFilename($fullFilename);
                $upload->setUserId($userId);
                
                $upload->setType(substr($file['type'], 0, strpos($file['type'], '/')));
                $this->uploadsTable->saveUpload($upload);
            }
        }
    }

    //save file
    public function saveFile($request, $userId) {
        $ds = DIRECTORY_SEPARATOR;

        // create dir md5 user_id if not exist
        if (!is_dir('public' . $ds . 'uploads')) {
            mkdir('public' . $ds . 'uploads');
        }

        if (!empty($_FILES)) {
            $files = $request->getFiles()->toArray();
            $file = $files['file'];

            $md5UserId = md5($userId);
            $pathdir = 'public' . $ds . 'uploads' . $ds . $md5UserId . $ds;
            if (!is_dir($pathdir)) {
                mkdir($pathdir);
            }
            $ext = substr($file['name'], strpos($file['name'], '.'));
            $filename = substr($file['name'], 0, strpos($file['name'], '.'));
            $md5Filename = md5($filename . rand(0, 9999)) . $ext;
            $fullFilename = $pathdir . $md5Filename;

            /* validator's
              $size = new Size(array('min'=>200));
              $extention = new \Zend\Validator\File\Extension(array('jpg'), true);
              $isimage = new \Zend\Validator\File\IsImage();
              $validator = new \Zend\Validator\File\MimeType(array('image', 'audio'));
              $adapter = new \Zend\File\Transfer\Adapter\Http();
              $adapter->setValidators(array($validator), $files['file']['name']);
              if ($adapter->isValid()){
              } */

            move_uploaded_file($file['tmp_name'], $fullFilename);

            //save file information in db
            $upload = new Upload();
            $upload->setFilename($filename);
            $upload->setFilepath('http://' . $_SERVER['SERVER_NAME'] . '/uploads' .
                    '/' . $md5UserId . '/' . $md5Filename);
            $upload->setFullFilename($fullFilename);
            $upload->setUserId($userId);
            $upload->setType(substr($file['type'], 0, strpos($file['type'], '/')));
            $this->uploadsTable->saveUpload($upload);
            
            return $this->uploadsTable->getUploadByFullFilename($fullFilename);
        }
    }

    // delete file!!!
    public function deleteFile($id) {
        $id = (int) $id;
        if ($id) {
            $fullFilename = $this->uploadsTable->getUploadById($id)->full_filename;
            $this->uploadsTable->deleteUpload($id);
            $status = 'ok';
            if (file_exists($fullFilename)) {
                unlink($fullFilename);
            }
        } else {
            $status = 'bad';
        }
        return $status;
    }
    
    public function getFilePath($id) {
        $file = $this->uploadsTable->getUploadById($id);
        return $file->getFilepath();
    }
    
    public function getFilename($id) {
        $file = $this->uploadsTable->getUploadById($id);
        return $file->getFilename();
    }
}
