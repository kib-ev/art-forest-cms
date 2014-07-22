<?php

namespace Users\Form\Register\Filter;

use Zend\InputFilter\InputFilter;

class Individual extends InputFilter
{
    public function __construct()
    {

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 140,
                    ),
                ), array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'org_name',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'last_name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'first_name',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'middle_name',
            'required' => true,
        ));


        $this->add(array(
            'name' => 'country',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'city',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'region',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'street',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'house',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'office',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'unp',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'egr_org',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'egr_num',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'egr_date',
            'required' => true,
        ));

        $this->add(array(
            'name' => 'bank',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'bank_code',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'bank_address',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'bank_acc',
            'required' => true,
        ));
    }

}
