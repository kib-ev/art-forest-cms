<?php

namespace User\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="user_data")
 */
class UserData {

    const USER_ID = 'user_id';
    const FIELD_NAME = 'field_name';
    const FIELD_TYPE = 'field_type';
    const FIELD_VALUE = 'field_value';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $avatar_upload_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $card_upload_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $about;

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
