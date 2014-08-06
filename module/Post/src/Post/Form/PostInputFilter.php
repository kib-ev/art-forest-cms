<?php

namespace Post\Form;

use Zend\InputFilter\InputFilter;

class PostInputFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
        ));
    }
}
