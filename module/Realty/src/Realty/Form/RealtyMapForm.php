<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyMapForm extends Form {

    public function __construct($name = null) {
        parent::__construct('realty-map-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'realty-map-form');
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
            'name' => 'position_x',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "position_x",
            ),
        ));

        $this->add(array(
            'name' => 'position_y',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "position_y",
            ),
        ));

        $this->add(array(
            'name' => 'redirect',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => '',
                'value' => '/realty/edit-step-4/',
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
