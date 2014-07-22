<?php

namespace Banners\Form;

use Zend\Form\Form;
use Banners\Model\Banner;

class SimpleBannerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('simple-banner-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', '');
        $this->setAttribute('action', '/banners/simple/process');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'image_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'file',
            'attributes' => array(
                'type' => 'file',
                'class' => 'file',
            ),
            'options' => array(
                'label' => "file",
            ),
        ));

        $this->add(array(
            'name' => 'type',
            'attributes' => array(
                'type' => 'hidden',
                'value' => Banner::SIMPLE_BANNER
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'submit'
            ),
        ));
    }

}