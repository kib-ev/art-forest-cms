<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Catalog\Data\Location;

class FilterController extends AbstractActionController
{
    public function filterAction()
    {
        if ($this->request->isXmlHttpRequest()) {
            $this->ajaxFilterAction();
        }
        return array();
    }

    public function ajaxFilterAction()
    {
        return array();
    }

    public function ajaxCatalogAction()
    {
        $answer = array(
            'status' => 'ok',
            'catalog' => Location::getCatalog(),
        );
        return new \Zend\View\Model\JsonModel($answer);
    }

}