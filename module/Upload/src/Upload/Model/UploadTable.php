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
                array('user_id' => $userId)
                );
        return $rowset;
    }
    
    public function getUploadByFullFilename($fullFilename) {
        $rowset = $this->tableGateway->select(
                array('full_filename' => $fullFilename)
                );
        return $rowset->current();
    }
    
    public function saveUpload(Upload $upload) {
        $data = array(
            'user_id' => $upload->getUserId(),
            'filename' => $upload->getFilename(),
            'filepath' => $upload->getFilepath(),
            'full_filename' => $upload->getFullFilename(),
            'type' => $upload->getType()
            
        );
        $this->tableGateway->insert($data);
        
    }
    
    public function deleteUpload($id) {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function getUploadById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        return $rowset->current();
    }

}
