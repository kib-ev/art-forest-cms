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
                array('userId' => $userId)
        );
        return $rowset;
    }

    public function getUploadByPath($uploadPath) {
        $rowset = $this->tableGateway->select(
                array('path' => $uploadPath)
        );
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function getUploadByUrl($uploadUrl) {
        $rowset = $this->tableGateway->select(
                array('url' => $uploadUrl)
        );
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function saveUpload(Upload $upload) {
        $data = $upload->getArrayCopy();

        unset($data['id']);
        $uploadId = (int) $upload->get('id');

        if ($uploadId == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUploadById($uploadId)) {
                $this->tableGateway->update($data, array('id' => $uploadId));
            }
        }
    }

    public function deleteUploadById($uploadId) {
        $this->tableGateway->delete(array('id' => $uploadId));
    }

    public function getUploadById($uploadId) {
        $uploadId = (int) $uploadId;
        $rowset = $this->tableGateway->select(array('id' => $uploadId));
        $row = $rowset->current();
        return $row ? $row : null;
    }
}
