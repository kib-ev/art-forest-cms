<?php

namespace Banners\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Banners\Model\Banner;

class SimpleController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        $bannerTable = $this->getServiceLocator()->get('banners_table');

        $banner = $bannerTable->getBannerByTypeForUser(Banner::SIMPLE_BANNER, $user->user_id);
        if (!isset($banner)) {
            $newBanner = new Banner();
            $newBanner->exchangeArray(array(
                'user_id' => $user->user_id,
                'type' => Banner::SIMPLE_BANNER,
                'is_on' => false,
            ));
            $banner = $bannerTable->saveBanner($newBanner);
        }
        return array('banner' => $banner);
    }

    public function ajaxProcessAction()
    {
        if (!$this->request->isXmlHttpRequest()) {
            return $this->redirect()->toUrl('/banners/simple/add');
        }

        $uploadsManager = $this->getServiceLocator()->get('uploads_manager');
        $user = $this->getServiceLocator()->get('logged_in_user');

        $imageFile = $uploadsManager->saveFile($this->request, $user->getId());

        $answer = array(
            'status' => 'ok',
            'src' => $imageFile->getFilepath(),
            'image_id' => $imageFile->id,
        );

        return new \Zend\View\Model\JsonModel($answer);
    }

    public function processAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/banners/simple/add');
        }
        $this->saveBanner($this->getRequest());
        return $this->redirect()->toUrl('/banners');
    }

    public function saveBanner(\Zend\Http\Request $request)
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        $data = array(
            'id' => $request->getPost('id'),
            'user_id' => $user->user_id,
            'image' => $request->getPost('image'),
            'image_id' => $request->getPost('image_id'),
            'create_date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
            'off_date' => \Users\DateTime\DateTime::getMaxDateTimeString(),
            'type' => Banner::SIMPLE_BANNER,
            'is_on' => Banner::DEFAULT_IS_ON,
        );

        $newBanner = new \Banners\Model\Banner();
        $newBanner->exchangeArray($data);

        $bannersTable = $this->getServiceLocator()->get('banners_table');
        $banner = $bannersTable->saveBanner($newBanner);

        return $banner;
    }

}
