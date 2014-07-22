<?php

namespace Banner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BannerController extends AbstractActionController
{
    public function indexAction()
    {
        $bannersTable = $this->getServiceLocator()->get('banners_table');

        return new ViewModel(array(
            'banners' => $bannersTable->fetchAll(),
        ));
    }

    public function listAction()
    {
        $banners = $this->getBannersArray();

        return new ViewModel(array(
            'bannerList' => $banners,
        ));
    }

    public function getBannersArray()
    {

        $bannersTable = $this->getServiceLocator()->get('banners_table');
        $bannerList = $bannersTable->fetchAll();

        $banners = array();

        foreach ($bannerList as $banner) {

            array_push($banners, $banner);
        }

        return $banners;
    }

}
