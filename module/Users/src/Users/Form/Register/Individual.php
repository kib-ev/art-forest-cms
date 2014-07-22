<?php

namespace Users\Form\Register;

use Zend\Form\Form,
    Zend\Captcha;
use Catalog\Data\Location;

class Individual extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('individual-register-form'); // this name is not used 
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
                'placeholder' => 'ИП Иванов Петр Михайлович'
            ),
            'options' => array(
                'label' => "Наименование юридического лица",
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
            'name' => 'zip',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '220123'
            ),
            'options' => array(
                'label' => "Индекс",
            ),
        ));

        $this->add(array(
            'name' => 'street',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Воронянского'
            ),
            'options' => array(
                'label' => "Улица",
            ),
        ));

        $this->add(array(
            'name' => 'house',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '45-1'
            ),
            'options' => array(
                'label' => "Номер дома - корпус",
            ),
        ));

        $this->add(array(
            'name' => 'office',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '58'
            ),
            'options' => array(
                'label' => "Номер офиса, квартиры",
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

        /* ######################################################### ERG #### */

        $this->add(array(
            'name' => 'unp',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => '192000250'
            ),
            'options' => array(
                'label' => "УНП вашей организации",
            ),
        ));

        $this->add(array(
            'name' => 'egr_org',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Администрация Первомайского района'
            ),
            'options' => array(
                'label' => "Орган, осуществивший регистрацию",
            ),
        ));

        $this->add(array(
            'name' => 'egr_num',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '734025'
            ),
            'options' => array(
                'label' => "Номер решегия о государственной регистрации",
            ),
        ));

        $this->add(array(
            'name' => 'egr_date',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '08-10-2013'
            ),
            'options' => array(
                'label' => "Дата государствнной регистрации",
            ),
        ));

        /* ######################################################### BANK ### */

        $this->add(array(
            'name' => 'bank',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'ОАО Беларусьбанк'
            ),
            'options' => array(
                'label' => "Банк",
            ),
        ));

        $this->add(array(
            'name' => 'bank_code',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '764'
            ),
            'options' => array(
                'label' => "Код банка",
            ),
        ));

        $this->add(array(
            'name' => 'bank_address',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'г.Минск, ул. Комсомольская, 13'
            ),
            'options' => array(
                'label' => "Адрес банка",
            ),
        ));

        $this->add(array(
            'name' => 'bank_acc',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '123456789632541'
            ),
            'options' => array(
                'label' => "Расчетный счет",
            ),
        ));
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
