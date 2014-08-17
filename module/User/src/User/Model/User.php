<?php

namespace User\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="user")
 */
class User {

    const USER_ID = 'user_id';
    const USER_NAME = 'username';
    const DISPLAY_NAME = 'display_name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const STATE = 'state';
    const CREATE_DATE = 'create_date';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $username;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $display_name;

    /**
     *  @ORM\Column(type="text", nullable=true) 
     */
    protected $email;

    /**
     *  @ORM\Column(type="text", nullable=true) 
     */
    protected $password;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $state;

//    protected $activationToken;
//    protected $forgotPasswordToken;
//    protected $lastLoginIp;
//    protected $failedLoginIp;
//    protected $lastLoginDate;

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
