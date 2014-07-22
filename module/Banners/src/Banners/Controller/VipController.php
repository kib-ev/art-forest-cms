<?php

namespace Banners\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Banners\Model\Banner;

class VipController extends AbstractActionController
{
    private $type = Banner::VIP_BANNER;

    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        $bannerTable = $this->getServiceLocator()->get('banners_table');

        $banner = $bannerTable->getBannerByTypeForUser(Banner::VIP_BANNER, $user->user_id);
        if (!isset($banner)) {
            $newBanner = new Banner();
            $newBanner->exchangeArray(array(
                'user_id' => $user->user_id,
                'type' => Banner::VIP_BANNER,
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
            'off_date' => date("Y-m-d H:i:s", strtotime("+" . BannersController::LIFETIME_BANNER)),
            'type' => Banner::VIP_BANNER,
            'is_on' => Banner::DEFAULT_IS_ON,
            'title' => $request->getPost()->title,
            'cost' => $request->getPost()->cost,
        );

        $newBanner = new \Banners\Model\Banner();
        $newBanner->exchangeArray($data);

        $bannersTable = $this->getServiceLocator()->get('banners_table');
        $banner = $bannersTable->saveBanner($newBanner);

        return $banner;
    }

    public function createBanner(\Zend\Http\Request $request, array $data)
    {
        $user = $this->getServiceLocator()->get('logged_in_user');

        $data['title'] = $request->getPost()->title;
        $data['cost'] = $request->getPost()->cost;
        $data['hits'] = $request->getPost()->hits;
        $data['id'] = $request->getPost()->id;
        $data['image_id'] = $request->getPost()->image_id;
        $data['user_id'] = $user->getId();
        $data['create_date'] = date("Y-m-d H:i:s");
        $data['off_date'] = date("Y-m-d H:i:s", strtotime("+" . BannersController::LIFETIME_BANNER));

        $data['is_on'] = Banner::DEFAULT_IS_ON;
        $data['type'] = $this->type;

        $banner = new \Banners\Model\Banner();
        $banner->exchangeArray($data);

        $bannersTable = $this->getServiceLocator()->get('banners_table');
        $bannersTable->saveBanner($banner);
    }

    public function createBannerJson(\Zend\Http\Request $request)
    {
        $uploadsManager = $this->getServiceLocator()->get('uploads_manager');
        $user = $this->getServiceLocator()->get('logged_in_user');
        $imageFile = $uploadsManager->saveFile($request, $user->getId());

        $data['id'] = $request->getPost()->id;
        $data['image_id'] = $imageFile->getId();
        $data['user_id'] = $user->getId();
        $data['create_date'] = date("Y-m-d H:i:s");
        $data['off_date'] = date("Y-m-d H:i:s", strtotime("+" . BannersController::LIFETIME_BANNER));
        $data['is_on'] = Banner::DEFAULT_IS_ON;
        $data['type'] = $this->type;

        $banner = new \Banners\Model\Banner();
        $banner->exchangeArray($data);

        $bannersTable = $this->getServiceLocator()->get('banners_table');
        $dbBanner = $bannersTable->saveBanner($banner);

        $answer = array(
            'image_url' => $imageFile->getFilepath(),
            'image_id' => $imageFile->getId(),
            'banner_id' => $dbBanner->id,
        );

        return $answer;
    }

}
