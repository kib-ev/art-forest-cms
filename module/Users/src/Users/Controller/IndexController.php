<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Users\Controller\AuthController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toUrl(AuthController::LOGIN);
    }

}