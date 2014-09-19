<?php

namespace Post\Form;

use Zend\Form\Form;

class PostForm extends Form {

    public function __construct($name = null) {
        parent::__construct('form-add-post');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-post');
        $this->setAttribute('action', '/post/process');

        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => 'hide'
            ),
            'options' => array(
                'label' => "user_id",
            ),
        ));

        $this->add(array(
            'name' => 'post_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => 'hide'
            ),
            'options' => array(
                'label' => "post_id",
            ),
        ));

        $this->add(array(
            'name' => 'category_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => "category_id",
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
//                'required' => 'required',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "title",
            ),
        ));

        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control desc',
            ),
            'options' => array(
                'label' => "text",
            ),
        ));

        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'class' => 'ui-spinner',
                'maxlength' => 10,
                'max' => 999999999,
                'min' => 0,
            ),
            'options' => array(
                'label' => "price",
            ),
        ));

        $this->add(array(
            'name' => 'public',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ),
            'options' => array(
                'label' => "public",
            ),
        ));

        $this->add(array(
            'name' => 'tags',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => "tags",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class' => 'btn btn-lg submit ui-button-text ui-button',
            ),
            'options' => array(
                'label' => "submit",
            ),
        ));
    }
}
