<?php

namespace Dialogs\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="dialogs")
 */
class Dialog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="integer") */
    public $sender_id;

    /** @ORM\Column(type="integer") */
    public $recipient_id;

    /** @ORM\Column(type="text") */
    public $text;

    /** @ORM\Column(type="datetime") */
    public $create_date;

    /** @ORM\Column(type="boolean", options={"default"="1"}) */
    public $is_new;

    /** @ORM\Column(type="integer", nullable=true) */
    public $deleted_by_user_id;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->sender_id = (isset($data['sender_id'])) ? $data['sender_id'] : null;
        $this->recipient_id = (isset($data['recipient_id'])) ? $data['recipient_id'] : NULL;
        $this->text = (isset($data['text'])) ? $data['text'] : null;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
        $this->is_new = (isset($data['is_new'])) ? $data['is_new'] : NULL;
    }

    // this method needed to work Hydrator  $anyForm->bind($entity)
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get sender id.
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * Set sender id.
     *
     * @param int $senderId
     */
    public function setSenderId($senderId)
    {
        $this->sender_id = (int) $senderId;
    }

    /**
     * Get recipient id.
     *
     * @return int
     */
    public function getRecipientId()
    {
        return $this->recipient_id;
    }

    /**
     * Set recipient id.
     *
     * @param int $resipientId
     */
    public function setRecipientId($resipientId)
    {
        $this->recipient_id = (int) $resipientId;
    }

    /**
     * Get dialog text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set dialog text.
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get datetime.
     *
     * @return \Date
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * set datetime.
     *
     * @param DateTime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate; // todo php date to mysql
    }

    /**
     * Get "is new" status.
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->is_new;
    }

    /**
     * Set "is new" status.
     *
     * @param boolean
     */
    public function setIsNew($isNew)
    {
        $this->is_new = $isNew;
    }

}