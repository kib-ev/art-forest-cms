<?php

namespace Post\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Post\Model\Attachment;

class PostViewWidget extends AbstractHelper {

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    protected $userId;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($postId) {
        $sm = $this->sm;

        $postTable = $sm->get('post_table');

        $post = $postTable->getPostById($postId);

        $data = array(
            'post' => $post,
            'sm' => $sm,
        );

        $view = new ViewModel();
        $view->setTemplate('/helper/post/view');
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
