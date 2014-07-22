<?php

namespace Dialogs\Form;

use Zend\Form\Form;

class SendMsgForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('send-msg-form'); // this name is not used 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('action', '/dialog/sendMessage');
        
        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Введите ваше сообщение',
            ),
            'options' => array(
                'label' => "Text",
            ),
        ));
    }
}