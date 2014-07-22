<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Comment;

class CommentTable {
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {

        $this->tableGateway = $tableGateway;
    }

    public function fetchAllByPostId($postId) {

        return $this->tableGateway->select(array('post_id' => $postId));
    }

    public function saveComment(Comment $comment) {
        $data = array(
            'user_id' => $comment->getUserId(),
            'post_id' => $comment->getPostId(),
            'text' => $comment->getText(),
            'date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
        );
        $this->tableGateway->insert($data);
    }

    public function deleteComment($id) {
        
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function deleteCommentByUserId($id, $userId) {
        
        $this->tableGateway->delete(array('id' => $id, 'user_id' => $userId));
    }

    public function countComments($postId) {

        $rowset = $this->fetchAllByPostId($postId);
        return $rowset->count();
    }
    
    public function getCommentById($id) {
        
        return $this->tableGateway->select(array('id' => $id))->current();
    }
}
