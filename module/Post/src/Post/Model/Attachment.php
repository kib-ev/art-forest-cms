<?php

namespace Post\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="attachment")
 */
class Attachment {

    const ATTACHMENT_ID = 'attachment_id';
    const USER_ID = 'user_id';
    const UPLOAD_ID = 'upload_id';
    const POST_ID = 'post_id';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $attachment_id;

    /**
     * @ORM\Column(type="integer") 
     */
    protected $user_id;

    /**
     * @ORM\Column(type="integer") 
     */
    protected $upload_id;

    /**
     * @ORM\Column(type="integer") 
     */
    protected $post_id;

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
