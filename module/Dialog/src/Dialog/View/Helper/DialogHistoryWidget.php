<?php

namespace Dialog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class DialogHistoryWidget extends AbstractHelper {

    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($currentUserId, $selectedUserId) {
        $sm = $this->sm;

        $dialogTable = $sm->get('dialog_table');
        $dialogs = $dialogTable->getDialogsForUsers($currentUserId, $selectedUserId);

        $view = new ViewModel(
                array(
            'currentUserId' => $currentUserId,
            'selectedUserId' => $selectedUserId,
            'dialogs' => $dialogs,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
