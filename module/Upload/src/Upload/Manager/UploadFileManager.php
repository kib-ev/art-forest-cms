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
                //$md5UserId = md5($userId);
                $pathdir = 'public' . $ds . 'uploads' . $ds . 'user' . $userId . $ds;
                if (!is_dir($pathdir)) {
                    mkdir($pathdir);
                }
                $ext = substr($file['name'], strpos($file['name'], '.'));
                $filename = $file['name'];
                //$md5Filename = md5($filename . rand(0, 9999)) . $ext;
                $fullFilename = $pathdir . $filename . $ext;

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

                $fileUrl = '/uploads' .
                        '/' . 'user' . $userId . '/' . $filename . $ext;

                $upload->setFilepath($fileUrl);

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

            $dirPath = 'public' . $ds . 'uploads' . $ds . 'user' . $userId . $ds;
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }

            $tempFile = $file['tmp_name'];
            $fileName = substr($file['name'], 0, strpos($file['name'], '.'));
            $fileNameTranslit = $this->rus2translit($fileName);
            $fileExt = substr($file['name'], strpos($file['name'], '.'));
            $filePath = $dirPath . $fileNameTranslit . $fileExt;

            move_uploaded_file($tempFile, $filePath);

            //save file information in db
            $fileUrl = "/uploads/user$userId/$fileNameTranslit$fileExt";

            $data = array(
                'name' => $fileName . $fileExt,
                'userId' => $userId,
                'path' => $filePath,
                'url' => $fileUrl,
                'type' => $file['type'],
            );

            $upload = new \Upload\Model\Upload($data);
            $this->uploadsTable->saveUpload($upload);

            return $this->uploadsTable->getUploadByPath($filePath);
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

    public function deleteUploadById($id) {
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

    function rus2translit($string) {

        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            ' ' => '-'
        );

        return strtr($string, $converter);
    }
}
