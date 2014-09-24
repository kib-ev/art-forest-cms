<?php

namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class UserPanelWidget extends AbstractHelper {

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    protected $userId;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke() {
        $sm = $this->sm;

        $currentUserId = $sm->get('logged_in_user_id');
        $userTable = $sm->get('user_table');
        $user = $userTable->getUserById($currentUserId);


        $data = array(
            'user' => $user,
        );

        $view = new ViewModel();
        $view->setTemplate($this->viewTemplate);
        $view->setVariables($data);

        return $this->getView()->render($view);
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
