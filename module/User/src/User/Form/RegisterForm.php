<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form {

    public function __construct($name = null) {
        parent::__construct('form-register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-register');
        $this->setAttribute('action', '/user/register/process');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'required' => 'required'
            ),
            'options' => array(
                'label' => "email",
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'maxlength' => 100,
            ),
            'options' => array(
                'label' => "password",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Register',
                'class' => 'button',
            ),
            'options' => array(
                'label' => "register",
            ),
        ));
    }
}
