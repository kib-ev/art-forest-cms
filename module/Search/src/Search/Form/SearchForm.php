<?php

namespace Search\Form;

use Zend\Form\Form;

class SearchForm extends Form {

    public function __construct($name = null) {
        parent::__construct('search'); // this name is not used 
        $this->setAttribute('id', 'search-form');
        $this->setAttribute('method', 'get');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('action', '/post/search/');

        $this->add(array(
            'name' => 'query',
            'attributes' => array(
                'type' => 'search',
                'required' => 'required',
                'placeholder' => '',
                'autocomplete' => "off",
            ),
            'options' => array(
                'label' => 'search',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'поиск',
                'class' => 'submit',
            ),
            'options' => array(
                'label' => 'submit',
            ),
        ));
    }
}
