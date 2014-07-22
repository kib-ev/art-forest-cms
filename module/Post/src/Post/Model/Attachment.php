<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="attachments")
 */
class Attachment {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /** @ORM\Column(type="integer") */
    protected $upload_id;

    /** @ORM\Column(type="integer") */
    protected $post_id;
    
    /** @ORM\Column(type="text") */
    protected $type;
    
     public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->upload_id = (!empty($data['upload_id'])) ? $data['upload_id'] : null;
        $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
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
     * Get upload id.
     *
     * @return int
     */
    public function getUploadId() {
        return $this->upload_id;
    }

    /**
     * Set upload id.
     *
     * @param int $upload_id
     */
    public function setUploadId($uploadId) {
        $this->upload_id = (int) $uploadId;
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
     * Get type.
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type) {
        $this->type = (int) $type;
    }
}