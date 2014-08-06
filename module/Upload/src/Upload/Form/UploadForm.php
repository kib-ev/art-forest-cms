<?php

namespace Upload\Form;

use Zend\Form\Form;

class UploadForm extends Form {

    public function __construct($name = null) {
        parent::__construct('form-file-upload');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-post');
        $this->setAttribute('action', '/upload/process');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => "id",
            ),
        ));

        $this->add(array(
            'name' => 'file',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => "file",
            ),
        ));


        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control title',
//                'required' => 'required',
                'placeholder' => '',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "Заголовок",
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control desc',
                //'required' => 'required',
                'placeholder' => 'Описание темы',
            ),
            'options' => array(
                'label' => "Описание",
            ),
        ));

        $this->add(array(
            'name' => 'alt',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control desc',
                'placeholder' => 'Описание темы',
            ),
            'options' => array(
                'label' => "Атрибут alt",
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Загрузить',
                'class' => 'btn btn-lg submit',
            ),
            'options' => array(
                'label' => "upload",
            ),
        ));
    }
}
