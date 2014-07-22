<?php

namespace Users\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="user_data")
 */
class UserData
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
    public $avatar_url;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
        $this->avatar_url = (isset($data['avatar_url'])) ? $data['avatar_url'] : NULL;

    }

    public function getAvatarUrl() {
        return !empty($this->avatar_url) ? $this->avatar_url : 'http://' . $_SERVER['HTTP_HOST'] . '/img/default_avatar.png';
    }
}