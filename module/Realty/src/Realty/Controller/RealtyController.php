<?php

namespace Realty\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RealtyController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

