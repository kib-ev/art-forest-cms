<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Attachment;
use Zend\Db\Sql\Where;

class AttachmentTable {
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {

        $this->tableGateway = $tableGateway;
    }

    public function saveAttachment($upload_id, $post_id, $type) {
        $data = array(
            'upload_id' => $upload_id,
            'post_id' => $post_id,
            'type' => $type,
        );
        $this->tableGateway->insert($data);
    }
    
    public function fetchAllByPostId($post_id) {
        return $this->tableGateway->select(array('post_id' => $post_id));
    }
    
    public function countImages($post_id) {
        $rowset = $this->tableGateway->select(array('post_id' => $post_id, 'type' => 'image'));
        return $rowset->count();
    }
    
    public function countFiles($post_id) {
        
        $where = new  Where();
        $where -> equalTo('post_id', $post_id);
        $where -> notEqualTo('type', 'image');
        $rowset = $this->tableGateway->select($where);
        return $rowset->count();
    }
    
    public function deleteAttachment($upload_id) {
        $this->tableGateway->delete(array('upload_id' => $upload_id,));
    }
    
    public function getAttachmentById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('post_id' => $id));
        return $rowset;
    }
    
    public function getImagesByPostId($post_id) {
        $rowset = $this->tableGateway->select(array('post_id' => $post_id, 'type' => 'image'));
        return $rowset;
    }
    
//    public function getFilesByPostId($post_id) {
//        $rowset = $this->tableGateway->select(array('post_id' => $post_id, 'type' => 'files'));
//        return $rowset;
//    }
}