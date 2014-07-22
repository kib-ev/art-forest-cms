<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Like;

class LikeTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;
    }

    public function fetchAllByPostId($postId)
    {

        return $this->tableGateway->select(array('post_id' => $postId));
    }

    public function getByUserIdAndPostId($postId, $userId)
    {
        $rowset = $this->tableGateway->select(array('post_id' => $postId, 'user_id' => $userId));

        return $rowset->count() ? true : false;
    }

    public function getUserIdWithMaxLikeCount()
    {
        $sql = "SELECT user_id, sum(cnt) from ( SELECT p.user_id, l.post_id, COUNT(l.post_id) AS cnt FROM likes l, posts p WHERE l.post_id = p.id GROUP BY l.post_id ) t GROUP BY user_id LIMIT 1";
        $rowset = $this->tableGateway->adapter->query($sql, array());
        $row = $rowset->current();
        return ($row) ? $row->user_id : null;
    }

    public function saveLike(Like $like)
    {
        $data = array(
            'user_id' => $like->getUserId(),
            'post_id' => $like->getPostId(),
        );
        $this->tableGateway->insert($data);
    }

    public function deleteLike($userId)
    {
        $this->tableGateway->delete(array('id' => $userId));
    }

    public function countLikes($postId)
    {

        $rowset = $this->fetchAllByPostId($postId);
        return $rowset->count();
    }

    public function likePost($id, $user_id)
    {
        $id = (int) $id;
        $user_id = (int) $user_id;
        $sql = "SELECT COUNT(*) AS countLikes FROM likes WHERE post_id = $id AND user_id = $user_id";
        $rowset = $this->tableGateway->adapter->query($sql, array());
        foreach ($rowset as $like) {
            if ($like->countLikes) {
                $sql = "DELETE FROM likes WHERE post_id = $id AND user_id = $user_id";
                $this->tableGateway->adapter->query($sql, array());
            } else {
                $sql = "INSERT INTO likes (post_id, user_id) VALUES ($id, $user_id)";
                $this->tableGateway->adapter->query($sql, array());
            }
        }
    }

}