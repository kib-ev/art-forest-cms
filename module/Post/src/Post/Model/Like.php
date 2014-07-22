<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="likes")
 */
class Like {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="integer") */
    protected $user_id;

    /** @ORM\Column(type="integer") */
    protected $post_id;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Get id.
     *
     * @return int 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     */
    public function setId($id) {
        $this->id = (int) $id;
    }

    /**
     * Get user id.
     *
     * @return int 
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set user id.
     *
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->user_id = (int) $userId;
    }

    /**
     * Get post id.
     *
     * @return int 
     */
    public function getPostId() {
        return $this->post_id;
    }

    /**
     * Set post id.
     *
     * @param int $postId
     */
    public function setPostId($postId) {
        $this->post_id = (int) $postId;
    }

}
