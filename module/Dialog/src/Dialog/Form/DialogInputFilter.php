<?php

namespace Dialog\Form;

use Zend\InputFilter\InputFilter;

class DialogInputFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'message',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
        ));
    }
}
