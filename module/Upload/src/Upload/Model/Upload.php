<?php

namespace Upload\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="upload")
 */
class Upload {

    const UPLOAD_ID = 'upload_id';
    const USER_ID = 'user_id';
    const FILE_NAME = 'file_name';
    const FILE_PATH = 'file_path';
    const FILE_URI = 'file_uri';
    const FILE_TYPE = 'file_type';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $upload_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $file_name;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $file_path;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $file_uri;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $file_type;

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
