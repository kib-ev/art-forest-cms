<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyTypeForm extends Form {

    public function __construct($name = null) {
        parent::__construct('realty-type-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'realty-type-form');
        $this->setAttribute('action', '/realty/process');

        $this->add(array(
            'name' => 'realty_type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => 'realty_type',
            ),
        ));

        $this->add(array(
            'name' => 'redirect',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => '',
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
