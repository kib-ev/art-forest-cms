<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Post;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;


class PostTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {

        return $this->tableGateway->select(array('is_active' => '1'));
    }

    public function fetchAllByUserId($userId)
    {

        return $this->tableGateway->select(array('user_id' => $userId, 'is_active' => '1'));
    }

    public function deletePost($id, $userId)
    {

        $this->tableGateway->delete(array('id' => $id, 'user_id' => $userId));
    }

    public function savePost(Post $post)
    {
        $data = array(
            'user_id' => $post->getUserId(),
        );

        $id = (int) $post->getId();

        if ($id == 0) {
            $this->tableGateway->insert($data);
            //return id of new post
            $sql = "SELECT LAST_INSERT_ID() FROM posts AS id";
            $rowset = $this->tableGateway->adapter->query($sql, array());
            return $rowset->current();
        } elseif ($this->fetchById($id)) {

            $data = array(
                'title' => $post->getTitle(),
                'text' => $post->getText(),
                'price' => $post->getPrice(),
                'chaffer' => $post->getChaffer(),
                'tags' => $post->getTags(),
                'is_active' => $post->getIsActive(),
                'create_date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
                'country' => $post->country,
                'region' => $post->region,
                'city' => $post->city,
            );

            $this->tableGateway->update(
                    $data, array(
                'id' => $id,
                    )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function fetchByIdAndUserId($postId, $userId)
    {
        $postId = (int) $postId;
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('id' => $postId, 'user_id' => $userId));
        $row = $rowset->current();
        return $row;
    }

    public function fetchById($postId)
    {
        $postId = (int) $postId;
        $rowset = $this->tableGateway->select(array('id' => $postId));
        $row = $rowset->current();
        return $row;
    }

    public function searchAjax($input)
    {
        $sql = "SELECT * FROM posts WHERE title LIKE '%$input%' LIMIT 10";
        $rowset = $this->tableGateway->adapter->query($sql, array());
        return $rowset;
    }
    
    public function search($input, $order_by, $order, $country=null, $region=null, $city=null) {
        
        if ($city) {
            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region AND city=$city) ORDER BY $order_by $order LIMIT 100";
        } elseif ($region) {
            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region) ORDER BY $order_by $order LIMIT 100";
        } elseif ($country) {
            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND country=$country ORDER BY $order_by $order LIMIT 100";
       } else {
            $sql = "SELECT * FROM posts WHERE (title LIKE '%$input%' OR text LIKE '%$input%') ORDER BY $order_by $order LIMIT 100";
       }
        
        $rowset = $this->tableGateway->adapter->query($sql, array());
        return $rowset;
    }
    
    public function updatePostTime($id, $userId) {
    
        $data = array(
                'create_date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
            
            );
        
        
        $this->tableGateway->update(
                    $data, array(
                'id' => $id,
                'user_id' => $userId        
                    )
                );
        
    }
    
    public function getPostsByTags($tag) {
       if ($tag !=''){
        $select = new Select('posts');
        $select->where("tags LIKE '%{$tag}%' ")
               ->order('create_date DESC');

        $resultSet=$this->tableGateway->selectWith($select);
        return $resultSet;
    }
    }
    
}

