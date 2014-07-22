<?php

namespace Search\Form;

use Zend\Form\Form;

class SearchForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('search'); // this name is not used 
        $this->setAttribute('id', 'search-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('action', '/search/index');

        $this->add(array(
            'name' => 'query',
            'attributes' => array(
                'class' => 'search',
                'type' => 'search',
                'required' => 'required',
                'placeholder' => 'Ищем на ardfo',
                'autocomplete' => "off" ,
            ),
            'options' => array(
                'label' => 'Search String',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Найти',
                'class' => 'submit',
            ),
        ));
    }

}