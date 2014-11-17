<?php

namespace Category\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;

class CategoryKeyListWidget extends AbstractHelper {

    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke() {
        $sm = $this->sm;

//        $categoryId = (int) $categoryId;
//
        $categoryTable = $sm->get('category_table');
        $categories = $categoryTable->getKeyCategories();
//
//        $form = $sm->get('Category\Form\CategoryForm');
//
//        $form->bind($category);

        $view = new ViewModel(
                array(
            'categories' => $categories,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }

}
