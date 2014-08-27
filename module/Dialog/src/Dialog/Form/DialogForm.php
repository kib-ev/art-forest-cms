<?php

namespace Dialog\Form;

use Zend\Form\Form;

class DialogForm extends Form {

    public function __construct($name = null) {
        parent::__construct('dialog-form'); // this name is not used 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('action', '/dialog/sendMessage');

        $this->add(array(
            'name' => 'sender_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => 'hide'
            ),
            'options' => array(
                'label' => "sender_id",
            ),
        ));

        $this->add(array(
            'name' => 'recipient_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => 'hide'
            ),
            'options' => array(
                'label' => "recipient_id",
            ),
        ));

        $this->add(array(
            'name' => 'message',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '',
            ),
            'options' => array(
                'label' => "message",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'submit',
                'class' => '',
            ),
            'options' => array(
                'label' => "submit",
            ),
        ));
    }
}
