<?php

namespace Dialog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class DialogInputFormWidget extends AbstractHelper {

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($currentUserId, $selectedUserId) {
        $sm = $this->sm;

        $form = new \Dialog\Form\DialogForm();
        $form->setAttribute('action', "/dialog/process/$selectedUserId");

        $data = array(
            'sender_id' => $currentUserId,
            'recipient_id' => $selectedUserId,
        );

        $form->setInputFilter(new \Dialog\Form\DialogInputFilter());
        $form->setData($data);

        $view = new ViewModel(
                array(
            'currentUserId' => $currentUserId,
            'selectedUserId' => $selectedUserId,
            'form' => $form,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
