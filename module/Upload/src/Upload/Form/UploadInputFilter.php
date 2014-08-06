<?php

namespace Upload\Form;

use Zend\InputFilter\InputFilter;

class UploadInputFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'file',
            'required' => true,
            'validators' => array(
//           new \Zend\Validator\File\Upload(array('files'=> 'file')),
//                new \Zend\Validator\File\ImageSize(array('maxWidth' => 100, 'maxHeight' => 100)),
                //new \Zend\Validator\File\(array('max' => 5242880)),
//                new \Zend\Validator\File\FilesSize(array('min' => 100)),
            ),
        ));

//        $this->add(array(
//            'name' => 'title',
//            'required' => true,
//            'validators' => array(
//                new \Zend\Validator\EmailAddress(),
//            ),
//        ));
    }
}
