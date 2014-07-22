<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="comments")
 */
class Comment {

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

    /** @ORM\Column(type="text"), nullable=true) */
    protected $text;

    /** @ORM\Column(type="datetime") */
    protected $date;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
        $this->text = (!empty($data['text'])) ? $data['text'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
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
     * @param int $user_id
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
     * Set post id.S
     *
     * @param int $resipientId
     */
    public function setPostId($postId) {
        $this->post_id = (int) $postId;
    }

    /**
     * Get comment text.
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set comment text.
     *
     * @param string $text
     */
    public function setText($text) {
        $this->text = $text;
    }

    /**
     * Get datetime.
     *
     * @return date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * set datetime.
     *
     * @param DateTime $date
     */
    public function setDate($date) {
        $this->date = $date; // todo php date to mysql
    }
}
