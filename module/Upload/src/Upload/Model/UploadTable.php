<?php

namespace Upload\Model;

use Zend\Db\TableGateway\TableGateway;
use Upload\Model\Upload;

class UploadTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {

        $this->tableGateway = $tableGateway;
    }

    public function getUploadsByUserId($userId) {
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(
                array(Upload::USER_ID => $userId)
        );
        return $rowset;
    }

    public function getUploadByFilePath($uploadPath) {
        $rowset = $this->tableGateway->select(
                array(Upload::FILE_PATH => $uploadPath)
        );
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function getUploadByFileUri($uploadUri) {
        $rowset = $this->tableGateway->select(
                array(Upload::FILE_URI => $uploadUri)
        );
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function saveUpload(Upload $upload) {
        $data = $upload->getArrayCopy();

        unset($data[Upload::UPLOAD_ID]);
        $uploadId = (int) $upload->get(Upload::UPLOAD_ID);

        if ($uploadId == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUploadById($uploadId)) {
                $this->tableGateway->update($data, array(Upload::UPLOAD_ID => $uploadId));
            }
        }
    }

    public function deleteUploadById($uploadId) {
        $this->tableGateway->delete(array(Upload::UPLOAD_ID => $uploadId));
    }

    public function getUploadById($uploadId) {
        $uploadId = (int) $uploadId;
        $rowset = $this->tableGateway->select(array(Upload::UPLOAD_ID => $uploadId));
        $row = $rowset->current();
        return $row ? $row : null;
    }
}
