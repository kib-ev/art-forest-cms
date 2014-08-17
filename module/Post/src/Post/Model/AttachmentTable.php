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

    public function saveAttachment($userId, $postId, $uploadId) {
        $data = array(
            Attachment::USER_ID => $userId,
            Attachment::UPLOAD_ID => $uploadId,
            Attachment::POST_ID => $postId,
        );
        $this->tableGateway->insert($data);
    }

    public function fetchAllByPostId($post_id) {
        return $this->tableGateway->select(array(Attachment::POST_ID => $post_id));
    }

    public function countImages($post_id) {
        $rowset = $this->tableGateway->select(array(Attachment::POST_ID => $post_id));
        return $rowset->count();
    }

    public function countFiles($post_id) {

        $where = new Where();
        $where->equalTo(Attachment::POST_ID, $post_id);
        $rowset = $this->tableGateway->select($where);
        return $rowset->count();
    }

    public function deleteAttachmentById($attachmentId) {
        $this->tableGateway->delete(array(Attachment::ATTACHMENT_ID => $attachmentId));
    }

    public function getAttachmentById($attachmentId) {
        $attachmentId = (int) $attachmentId;
        $rowset = $this->tableGateway->select(array(Attachment::ATTACHMENT_ID => $attachmentId));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function getAttachmentsByPostId($postId) {
        $postId = (int) $postId;
        $rowset = $this->tableGateway->select(array(Attachment::POST_ID => $postId));
        return $rowset ? $rowset : null;
    }

    public function getAttachmentByUploadId($uploadId) {
        $uploadId = (int) $uploadId;
        $rowset = $this->tableGateway->select(array(Attachment::UPLOAD_ID => $uploadId));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function getImagesByPostId($post_id) {
        $rowset = $this->tableGateway->select(array(Attachment::POST_ID => $post_id));
        return $rowset;
    }
//    public function getFilesByPostId($post_id) {
//        $rowset = $this->tableGateway->select(array('post_id' => $post_id, 'type' => 'files'));
//        return $rowset;
//    }
}
