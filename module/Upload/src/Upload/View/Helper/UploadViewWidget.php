<?php

namespace Upload\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class UploadViewWidget extends AbstractHelper {

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

        $uploadTable = $sm->get('upload_table');

        $uploads = $uploadTable->getUploadsByUserId($currentUserId);

        $view = new ViewModel(
                array(
            'uploads' => $uploads,
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
