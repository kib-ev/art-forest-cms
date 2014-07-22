<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CatalogController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        return array();
    }

}

class geoObject
{
    public $id;
    public $parent_id;
    public $name;

    public function __construct($id, $parent_id, $name)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->name = $name;
    }

}