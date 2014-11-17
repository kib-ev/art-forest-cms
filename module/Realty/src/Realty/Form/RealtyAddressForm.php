<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyAddressForm extends Form {

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
            'name' => 'region',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "region",
            ),
        ));

        $this->add(array(
            'name' => 'discrict',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "discrict",
            ),
        ));

        $this->add(array(
            'name' => 'town',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "town",
            ),
        ));

        $this->add(array(
            'name' => 'street',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "street",
            ),
        ));

        $this->add(array(
            'name' => 'number_of_house',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "number_of_house",
            ),
        ));

        $this->add(array(
            'name' => 'apartment',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "apartment",
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
