<?php

namespace Banners\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class BannerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('banner-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', '');
        $this->setAttribute('action', '/banners/process');

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
            ),
            'options' => array(
                'label' => "file",
            ),
        ));

        $this->add(array(
            'name' => 'type',
            'attributes' => array(
                'type' => 'hidden',
                'value' => '3'
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'url',
            ),
            'options' => array(
                'label' => "url",
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'title',
            ),
            'options' => array(
                'label' => "title",
            ),
        ));

        $this->add(array(
            'name' => 'cost',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'cost',
            ),
            'options' => array(
                'label' => "cost",
            ),
        ));

        $this->add(array(
            'name' => 'sale',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'sale',
            ),
            'options' => array(
                'label' => "sale",
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'is_on',
            'options' => array(
                'label' => 'is_on',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
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