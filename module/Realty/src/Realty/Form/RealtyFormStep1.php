<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyFormStep1 extends Form {

    public function __construct($name = null) {
        parent::__construct('add-realty-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-realty');
        $this->setAttribute('action', '/realty/process');

//        $this->add(array(
//            'name' => 'user_id',
//            'attributes' => array(
//                'type' => 'text',
//                'readonly' => 'readonly',
//                'class' => 'hide'
//            ),
//            'options' => array(
//                'label' => "user_id",
//            ),
//        ));
//
//        $this->add(array(
//            'name' => 'realty_id',
//            'attributes' => array(
//                'type' => 'text',
//                'readonly' => 'readonly',
//                'class' => 'hide'
//            ),
//            'options' => array(
//                'label' => "realty_id",
//            ),
//        ));

        $this->add(array(
            'name' => 'realty_type',
            'attributes' => array(
                'type' => 'text',
//                'required' => 'required',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "realty_type",
            ),
        ));
        $this->add(array(
            'name' => 'redirect',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => '',
                'value' => '/realty/edit-step-2/',
            ),
            'options' => array(
                'label' => "redirect",
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить и продолжить',
                'class' => 'btn btn-lg submit ui-button-text ui-button',
            ),
            'options' => array(
                'label' => "submit",
            ),
        ));
    }

}
