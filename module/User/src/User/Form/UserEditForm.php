<?php

namespace User\Form;

use Zend\Form\Form;

class UserEditForm extends Form {

    public function __construct($name = null) {
        parent::__construct('user-edit-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'user-edit-form');
        $this->setAttribute('action', '/user/info/process');

        $this->add(array(
            'name' => \User\Model\User::USER_ID,
            'attributes' => array(
                'type' => 'text',
                'required' => 'required',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => "user_id",
            ),
        ));

        $this->add(array(
            'name' => \User\Model\User::EMAIL,
            'attributes' => array(
                'type' => 'email',
                'required' => 'required',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => "email",
            ),
        ));

        $this->add(array(
            'name' => \User\Model\User::DISPLAY_NAME,
            'attributes' => array(
                'type' => 'text',
                'required' => 'required',
            ),
            'options' => array(
                'label' => "display_name",
            ),
        ));

        $this->add(array(
            'name' => \User\Model\User::PHONE,
            'attributes' => array(
                'type' => 'tel',
            ),
            'options' => array(
                'label' => "phone",
            ),
        ));

        $this->add(array(
            'name' => 'about',
            'attributes' => array(
                'type' => 'textarea',
                'class' => '',
                'placeholder' => '',
            ),
            'options' => array(
                'label' => "about",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'save',
                'class' => 'button',
            ),
            'options' => array(
                'label' => "save",
            ),
        ));
    }
}
