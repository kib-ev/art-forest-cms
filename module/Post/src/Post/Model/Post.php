<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="integer") */
    public $user_id;

    /** @ORM\Column(type="text", nullable=true) */
    public $title;

    /** @ORM\Column(type="text", nullable=true) */
    public $text;

    /** @ORM\Column(type="integer", nullable=true) */
    public $price;

    /** @ORM\Column(type="text", nullable=true) */
    public $chaffer;

    /** @ORM\Column(type="text", nullable=true) */
    public $tags;

    /** @ORM\Column(type="boolean", options={"default"="0"}, nullable=true) */
    public $is_active;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $create_date;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $off_date;

    /** @ORM\Column(type="integer", nullable=true) */
    public $country;

    /** @ORM\Column(type="integer", nullable=true) */
    public $region;

    /** @ORM\Column(type="integer", nullable=true) */
    public $city;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->text = (!empty($data['text'])) ? $data['text'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
        $this->chaffer = (!empty($data['chaffer'])) ? $data['chaffer'] : null;
        $this->tags = (!empty($data['tags'])) ? $data['tags'] : null;
        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : null;
        $this->create_date = (!empty($data['create_date'])) ? $data['create_date'] : null;
        $this->off_date = (!empty($data['off_date'])) ? $data['off_date'] : null;

        $this->country = (!empty($data['country'])) ? $data['country'] : null;
        $this->region = (!empty($data['region'])) ? $data['region'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
    }

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
        return $this->id;
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
     * Get user id.
     *
     * @return int 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set user id.
     *
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = (int) $userId;
    }

    /**
     * Get title.
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (int) $title;
    }

    /**
     * Get post text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set post text.
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get price.
     *
     * @return int 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = (int) $price;
    }

    /**
     * Get chaffer.
     *
     * @return int 
     */
    public function getChaffer()
    {
        return $this->chaffer;
    }

    /**
     * Set chaffer.
     *
     * @param int $chaffer
     */
    public function setChaffer($chaffer)
    {
        $this->chaffer = $chaffer;
    }

    /**
     * Get tags.
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tags.
     *
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get is_active.
     *
     * @return int 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set is_active.
     *
     * @param int $is_active
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get create_date.
     *
     * @return create_date
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * set create_date.
     *
     * @param DateTime $create_date
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate; // todo php date to mysql
    }

    /**
     * Get off_date.
     *
     * @return off_date
     */
    public function getOffDate()
    {
        return $this->off_date;
    }

    /**
     * set off_date.
     *
     * @param DateTime $off_date
     */
    public function setOffDate($offDate)
    {
        $this->off_date = $offDate; // todo php date to mysql
    }

}