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
            'name' => 'id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => "id",
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control title',
                'required' => 'required',
                'placeholder' => ' Название темы',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "Введите заголовок",
            ),
        ));

        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control desc',
                'required' => 'required',
                'placeholder' => 'Описание темы',
            ),
            'options' => array(
                'label' => "Введите текст",
            ),
        ));

        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control price',
                'placeholder' => 'Цена у.е.',
                'maxlength' => 10,
                'max' => 999999999,
                'min' => 0,
            ),
            'options' => array(
                'label' => "Цена",
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
                'class' => 'form-control tags',
                'placeholder' => 'Введите сопровождающие теги, например: #авто #москвич #прицеп',
            ),
            'options' => array(
                'label' => "Введите сопровождающие теги",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class' => 'btn btn-lg submit',
            ),
            'options' => array(
                'label' => "submit",
            ),
        ));
    }
}
