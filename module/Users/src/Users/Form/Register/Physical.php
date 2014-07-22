<?php

namespace Users\Form\Register;

use Zend\Form\Form,
    Zend\Captcha;
use Catalog\Data\Location;

class Physical extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('physical-register-form'); // this name is not used 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');


        /* ####################################################### REG ###### */

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'example@mail.com'
            ),
            'options' => array(
                'label' => "E-mail",
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => "Пароль",
            ),
        ));

        /* #################################################### CONTACT ##### */

        $this->add(array(
            'name' => 'org_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иван Иванов'
            ),
            'options' => array(
                'label' => "Отображаемое имя",
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иванов'
            ),
            'options' => array(
                'label' => "Фамилия",
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иван'
            ),
            'options' => array(
                'label' => "Имя",
            ),
        ));
        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иванович'
            ),
            'options' => array(
                'label' => "Отчество",
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'attributes' => array(
                'options' => Location::getCatalogArray(),
            ),
            'options' => array(
                'label' => "Страна",
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'region',
            'attributes' => array(
                'options' => Location::getCatalogArray(),
            ),
            'options' => array(
                'label' => "Область, район",
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'city',
            'attributes' => array(
                'options' => Location::getCatalogArray(),
            ),
            'options' => array(
                'label' => "Населенный пункт",
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '+375172345678'
            ),
            'options' => array(
                'label' => "Контактный телефон",
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '+375172345678'
            ),
            'options' => array(
                'label' => "Контактный телефон",
            ),
        ));
//        $captcha = new \Zend\Form\Element\Captcha('captcha');
//        
//        $dumb = new \Zend\Captcha\Dumb();
//        $dumb->setLabel('');
//        $captcha->setCaptcha($dumb)
//                ->setLabel('Подтвердите что вы человек, введите текст в поле ниже');
//
//        $this->add($captcha);
        /* ################################################################## */

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Введите текст'
            ),
            'options' => array(
                'captcha' => new Captcha\Figlet(array(
                    'name' => 'foo',
                    'wordLen' => 4,
                    'timeout' => 300,
                    'messages' => array(
                        'badCaptcha' => 'Неправильно введена каптча!'
                    )
                        )),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Регистрация',
                'class' => 'submit'
            ),
        ));
    }

}