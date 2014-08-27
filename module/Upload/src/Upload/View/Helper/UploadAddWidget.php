<?php

namespace Upload\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class UploadAddWidget extends AbstractHelper {

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($currentUserId) {
        $sm = $this->sm;

        $form = new \Upload\Form\UploadForm();
        $form->setInputFilter(new \Upload\Form\UploadInputFilter());
        
        $view = new ViewModel(
                array(
            'form' => $form,
            'currentUserId' => $currentUserId,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
