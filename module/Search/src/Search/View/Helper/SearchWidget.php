<?php

namespace Search\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SearchWidget extends AbstractHelper
{
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke()
    {
        $form = new \Search\Form\SearchForm(); // todo place in the sm
        
        return $this->getView()->partial('search/search/widget', 
                array(
                    'form' => $form,
                ));
    }

}