<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyForm extends Form {

    public function __construct($name = null) {
        parent::__construct('add-realty-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-realty');
        $this->setAttribute('action', '/realty/process');

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
            'name' => 'realty_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => 'hide'
            ),
            'options' => array(
                'label' => "realty_id",
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
