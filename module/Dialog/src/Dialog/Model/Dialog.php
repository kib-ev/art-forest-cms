<?php

namespace Dialog\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="dialog")
 */
class Dialog {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $dialog_id;

    /**
     * @ORM\Column(type="integer") 
     */
    public $sender_id;

    /**
     * @ORM\Column(type="integer") 
     */
    public $recipient_id;

    /**
     * @ORM\Column(type="text"), nullable=true) 
     */
    public $message;

    /**
     * @ORM\Column(type="boolean", options={"default"="1"}) 
     */
    public $is_unread;

    /**
     * @ORM\Column(type="text"), nullable=true) 
     */
    public $create_date;

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
