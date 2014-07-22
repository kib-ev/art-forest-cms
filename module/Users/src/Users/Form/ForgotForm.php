<?php

namespace Users\Form\Register;

use Zend\Form\Form,
    Zend\Captcha;
use Catalog\Data\Location;

class Individual extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('forgot-form'); // this name is not used 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', '');
        $this->setAttribute('action', '/users/auth/forgot-process');
    }

}