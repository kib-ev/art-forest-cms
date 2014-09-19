<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="post")
 */
class Post {

    const POST_ID = 'post_id';
    const USER_ID = 'user_id';
    const TITLE = 'title';
    const TEXT = 'text';
    const PRICE = 'price';
    const PUBISH = 'public';
    const ACTIVE = 'active';
    const TAGS = 'tags';
    const CATEGORY_ID = 'category_id';
    const CREATE_DATE = 'create_date';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $post_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $text;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $price;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $public;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $tags;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $category_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $active;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $create_date;

    public function __construct($data = null) {
        if ($data) {
            $this->exchangeArray($data);
        }
    }

    public function exchangeArray($data) {
        $vars = $this->getArrayCopy();
        for ($i = 0; $i < count($vars); $i++) {
            $varName = key($vars);
            $this->$varName = (isset($data[$varName])) ? $data[$varName] : $this->$varName;
            next($vars);
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function get($varName) {
        $vars = $this->getArrayCopy();
        return $vars[$varName];
    }
}
