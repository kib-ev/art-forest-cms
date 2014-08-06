<?php

namespace Post\Model;

class Post {

    protected $id;
    protected $userId;
    protected $title;
    protected $text;
    protected $price;
    protected $public;
    protected $tags;
    protected $active;
    protected $createDate;

    public function __construct($data = null) {
        if ($data) {
            $this->exchangeArray($data);
        }
    }

    public function exchangeArray($data) {
        $vars = $this->getArrayCopy();
        for ($i = 0; $i < count($vars); $i++) {
            $varName = key($vars);
            $this->$varName = (isset($data[$varName])) ? $data[$varName] : NULL;
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
