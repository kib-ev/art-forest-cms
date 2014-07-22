<?php

namespace Upload\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="uploads")
 */
class Upload {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="integer") */
    public $user_id;

    
    /** @ORM\Column(type="text") */
    public $filename;
    
    /** @ORM\Column(type="text") */
    public $filepath;
    
    /** @ORM\Column(type="text") */
    public $full_filename;
    
    /** @ORM\Column(type="text") */
    public $type;
    
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->filename = (!empty($data['filename'])) ? $data['filename'] : null;
        $this->filepath = (!empty($data['filepath'])) ? $data['filepath'] : null;
        $this->full_filename = (!empty($data['full_filename'])) ? $data['full_filename'] : null;
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
     * Get filename.
     *
     * @return string 
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set filename.
     *
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }
    
    /**
     * Get filepath.
     *
     * @return string 
     */
    public function getFilepath() {
        return $this->filepath;
    }

    /**
     * Set filepath.
     *
     * @param string $filepath
     */
    public function setFilepath($filepath) {
        $this->filepath = $filepath;
    }
    
    /**
     * Get full_filename.
     *
     * @return string 
     */
    public function getFullFilename() {
        return $this->full_filename;
    }

    /**
     * Set full_filename.
     *
     * @param string $full_filename
     */
    public function setFullFilename($full_filename) {
        $this->full_filename = $full_filename;
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
     * Set type.
     *
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }
    
}