<?php

namespace Users\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="restore")
 */
class RestoreEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="integer", nullable=true) */
    public $userId;

    /** @ORM\Column(type="text", nullable=true) */
    public $key;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $createDate;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $offDate;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->userId = (isset($data['userId'])) ? $data['userId'] : NULL;
        $this->key = (isset($data['key'])) ? $data['key'] : NULL;
        $this->createDate = (isset($data['createDate'])) ? $data['createDate'] : NULL;
        $this->offDate = (isset($data['offDate'])) ? $data['offDate'] : NULL;
    }

}