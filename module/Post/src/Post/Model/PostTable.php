<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Post;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class PostTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        return $this->tableGateway->select(array('is_active' => '1'));
    }

    public function getPostsByUserId($userId) {

        return $this->tableGateway->select(array('user_id' => $userId));
    }

    public function deletePostById($postId) {

        $this->tableGateway->delete(array('post_id' => $postId));
    }

    /**
     * 
     * @param int $postId
     * @return \Zend\Db\ResultSet\ResultSet $row or null
     */
    public function getPostById($postId) {
        $postId = (int) $postId;
        $rowset = $this->tableGateway->select(array('post_id' => $postId));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    /**
     * 
     * @param \Post\Model\Post $post
     */
    public function savePost(Post $post) {
        $data = $post->getArrayCopy();

        unset($data['id']);
        $postId = (int) $post->get('post_id');

        if ($postId == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPostById($postId)) {
                $this->tableGateway->update($data, array('post_id' => $postId));
            }
        }
    }

    public function getLastUserPost($userId) {
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($userId) {
            $select->where->
                    equalTo('user_id', $userId);
            $select->order('create_date DESC');
        });

        $row = $result->current();
        return $row ? $row : null;
    }

    public function fetchByIdAndUserId($postId, $userId) {
        $postId = (int) $postId;
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('post_id' => $postId, 'user_id' => $userId));
        $row = $rowset->current();
        return $row;
    }

    public function fetchById($postId) {
        $postId = (int) $postId;
        $rowset = $this->tableGateway->select(array('post_id' => $postId));
        $row = $rowset->current();
        return $row;
    }

    public function search($data) {

        \Application\Log\Logger::info(json_encode($data));
        $rowset = $this->tableGateway->select(function(Select $select) use ($data) {

            $title = $data['query'];
            if (!empty($title)) {
                $select->where->like('title', '%' . $title . '%');
            }

            $user_id = $data['user_id'];
            if (isset($user_id)) {
                $select->where->equalTo('user_id', $user_id);
            }
        });
        return $rowset ? $rowset : null;
    }

//    public function search_($input, $order_by, $order, $country = null, $region = null, $city = null) {
//
//        if ($city) {
//            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region AND city=$city) ORDER BY $order_by $order LIMIT 100";
//        } elseif ($region) {
//            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region) ORDER BY $order_by $order LIMIT 100";
//        } elseif ($country) {
//            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND country=$country ORDER BY $order_by $order LIMIT 100";
//        } else {
//            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') ORDER BY $order_by $order LIMIT 100";
//        }
//
//        $rowset = $this->tableGateway->adapter->query($sql, array());
//        return $rowset;
//    }

    public function updatePostTime($id, $userId) {

        $data = array(
            'create_date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
        );


        $this->tableGateway->update(
                $data, array(
            'post_id' => $id,
            'user_id' => $userId
                )
        );
    }

    public function getPostsByTags($tag) {
        if ($tag != '') {
            $select = new Select('posts');
            $select->where("tags LIKE '%{$tag}%' ")
                    ->order('create_date DESC');

            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }
    }
}
