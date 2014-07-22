<?php

namespace Page\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="static_pages")
 */
class Page
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
    public $url;

    /** @ORM\Column(type="text", nullable=true) */
    public $title;

    /** @ORM\Column(type="text", nullable=true) */
    public $body;

    /** @ORM\Column(type="integer", nullable=true) */
    public $index;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $create_date;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : NULL;
        $this->body = (isset($data['body'])) ? $data['body'] : null;
        $this->index = (isset($data['index'])) ? $data['index'] : null;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
    }

}