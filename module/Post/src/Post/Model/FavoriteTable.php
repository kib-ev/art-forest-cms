<?php

namespace Post\Model;

use Zend\Db\TableGateway\TableGateway;
use Post\Model\Favorite;

class FavoriteTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {

        $this->tableGateway = $tableGateway;
    }

    public function fetchAllByUserId($userId) {

        return $this->tableGateway->select(array('user_id' => $userId));
    }
    
    public function fetchAllByPostId($postId) {

        $rowset = $this->tableGateway->select(array('post_id' => $postId));
        return $rowset;
    }
    
    public function getByUserIdAndPostId($postId, $userId) {
        $rowset = $this->tableGateway->select(array('post_id' => $postId, 'user_id' => $userId));
        return $rowset->current();
    }

    public function saveFavorite(Favorite $favorite) {
        $data = array(
            'user_id' => $favorite->getUserId(),
            'post_id' => $favorite->getPostId(),
        );
        $this->tableGateway->insert($data);
    }

    public function deleteFavorite($postId) {

        $this->tableGateway->delete(array('post_id' => $postId));
    }

    public function countFavorites($postId) {

        $rowset = $this->fetchAllByPostId($postId);
        return $rowset->count();
    }
    
    public function favoritePost($postId, $userId) {
        $postId = (int) $postId;
        $userId = (int) $userId;
        $sql = "SELECT COUNT(*) AS favor FROM favorites WHERE post_id = $postId AND user_id = $userId";
        $rowset = $this->tableGateway->adapter->query($sql, array());
        foreach ($rowset as $row) {
            if ($row->favor) {
                $sql = "DELETE FROM favorites WHERE post_id = $postId AND user_id = $userId";
                $this->tableGateway->adapter->query($sql, array());
            } else {
                $sql = "INSERT INTO favorites (post_id, user_id) VALUES ($postId, $userId)";
                $this->tableGateway->adapter->query($sql, array());
            }
        }
        return $row->favor;
    }
}