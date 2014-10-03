<?php

namespace Realty\Form;

use Zend\Form\Form;

class RealtyFormStep4Flat extends Form {

    public function __construct($name = null) {
        parent::__construct('add-realty-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-realty');
        $this->setAttribute('action', '/realty/process');

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
            'name' => 'number_of_rooms',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'number_of_rooms',
            ),
        ));

        $this->add(array(
            'name' => 'floor',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'floor',
            ),
        ));

        $this->add(array(
            'name' => 'floor_in_the_house',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'floor_in_the_house',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_house',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_house',
            ),
        ));

        $this->add(array(
            'name' => 'total_area',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'total_area',
            ),
        ));

        $this->add(array(
            'name' => 'residental_area',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'residental_area',
            ),
        ));

        $this->add(array(
            'name' => 'kitchen_area',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'kitchen_area',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_wc',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_wc',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_flooring',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_flooring',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_balcony',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_balcony',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_planning',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_planning',
            ),
        ));

        $this->add(array(
            'name' => 'type_of_repair',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'type_of_repair',
            ),
        ));

        $this->add(array(
            'name' => 'year_built',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'year_built',
            ),
        ));

        $this->add(array(
            'name' => 'year_overhaul',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'year_overhaul',
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
