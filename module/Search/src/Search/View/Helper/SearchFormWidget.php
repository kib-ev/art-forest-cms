<?php

namespace Search\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SearchFormWidget extends AbstractHelper
{
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke()
    {
        $form = new \Search\Form\SearchForm(); // todo place in the sm
        
        $view = new \Zend\View\Model\ViewModel();
        
        $view->setTemplate('helper/search/form');
        $view->setVariable('form', $form);
        
        return $this->getView()->render($view);
    }

}