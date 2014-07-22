<?php

namespace Page\Form;

use Zend\Form\Form,
    Zend\Captcha;
use Zend\Form\Element;

class FeedbackForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('Page');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'attributes' => array(
                'class' => 'captcha',
                'placeholder' => 'Введите текст',
            ),
            'options' => array(
                'captcha' => new Captcha\Figlet(array(
                    'name' => 'foo',
                    'wordLen' => 4,
                    'timeout' => 300,
                    'messages' => array(
                        'badCaptcha' => 'Не верно введена капча!'
                    )
                        )),
            ),
        ));
    }

}