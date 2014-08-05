<?php

namespace User\Model;

class User {

    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $activationToken;
    protected $forgotPasswordToken;
    protected $active;
    protected $lastLoginIp;
    protected $failedLoginIp;
    protected $lastLoginDate;
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
