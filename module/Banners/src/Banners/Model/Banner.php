<?php

namespace Banners\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="banners")
 */
class Banner
{
    const SIMPLE_BANNER = '1';
    const SALE_BANNER = '2';
    const LOGO_BANNER = '3';
    const VIP_BANNER = '4';
    const DEFAULT_IS_ON = '1'; // active
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DENIED = 'denied';
    const STATUS_PENDING = 'pending';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="integer") */
    public $user_id;

    /** @ORM\Column(type="integer", nullable=true) */
    public $image_id;

    /** @ORM\Column(type="text", nullable=true) */
    public $image;

    /** @ORM\Column(type="integer", nullable=true) */
    public $type;

    /** @ORM\Column(type="text", nullable=true) */
    public $url;

    /** @ORM\Column(type="text", nullable=true) */
    public $title;

    /** @ORM\Column(type="text", nullable=true) */
    public $cost;

    /** @ORM\Column(type="text", nullable=true) */
    public $sale;

    /** @ORM\Column(type="text", nullable=true) */
    public $hits;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $create_date;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $off_date;

    /** @ORM\Column(type="text") */
    public $is_on;

    /** @ORM\Column(type="text", nullable=true) */
    public $status;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
        $this->image_id = (isset($data['image_id'])) ? $data['image_id'] : NULL;
        $this->image = (isset($data['image'])) ? $data['image'] : NULL;
        $this->type = (isset($data['type'])) ? $data['type'] : NULL;
        $this->url = (isset($data['url'])) ? $data['url'] : NULL;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
        $this->cost = (isset($data['cost'])) ? $data['cost'] : NULL;
        $this->sale = (isset($data['sale'])) ? $data['sale'] : NULL;
        $this->hits = (isset($data['hits'])) ? $data['hits'] : NULL;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
        $this->off_date = (isset($data['off_date'])) ? $data['off_date'] : NULL;
        $this->is_on = (isset($data['is_on'])) ? $data['is_on'] : NULL;
        $this->status = (isset($data['status'])) ? $data['status'] : NULL;
    }

}
