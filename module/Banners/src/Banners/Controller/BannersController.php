<?php

namespace Banners\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Banners\Model\Banner;

class BannersController extends AbstractActionController
{
    const LIFETIME_BANNER = '30 days';

    public function indexAction()
    {
        $bannersTable = $this->getServiceLocator()->get('banners_table');

        return new ViewModel(array(
            'banners' => $bannersTable->fetchAll()
        ));
    }

    public function addAction()
    {
        $type = $this->getTypeFromRoute();

        $user = $this->getServiceLocator()->get('logged_in_user');
        $bannerTable = $this->getServiceLocator()->get('banners_table');

        $banner = $bannerTable->getBannerByTypeForUser($type, $user->user_id);
        if (!isset($banner)) {
            $newBanner = new Banner();
            $newBanner->exchangeArray(array(
                'user_id' => $user->user_id,
                'type' => $type,
                'is_on' => false,
            ));
            $banner = $bannerTable->saveBanner($newBanner);
        }

        $view = new ViewModel();
        $view->setTemplate('banners/' . $type . '/add');
        $view->setVariable('banner', $banner);
        return $view;
    }

    public function getTypeFromRoute()
    {
        $type = $this->params()->fromRoute('type');
        if (!isset($type)) {
            // redirect
        }
        return $type;
    }

//    public function processAction()
//    {
//        if (!$this->request->isPost()) {
//            return $this->redirect()->toUrl('/banners/add');
//        }
//
//        $data = $this->request->getPost();
//        $form = new \Banners\Form\BannerForm();
//        $form->setData($data);
//
//        if (!$form->isValid()) {
//            $view = new ViewModel(array(
//                'form' => $form,
//                'error' => true
//            ));
//
//            $view->setTemplate('banners/banners/add');
//            return $view;
//        }
//
//        // save banner ............
//        $this->createBanner($this->getRequest(), $form->getData());
//
//        return $this->redirect()->toUrl('/banners');
//    }
//    public function createBanner(\Zend\Http\Request $request, array $data)
//    {
//        $uploadsManager = $this->getServiceLocator()->get('uploads_manager');
//        $user = $this->getServiceLocator()->get('logged_in_user');
//        $imageFile = $uploadsManager->saveFile($request, $user->getId());
//
//        $data['user_id'] = $user->getId();
//        $data['image_id'] = $imageFile->getId();
//        $data['create_date'] = date("Y-m-d H:i:s");
//        $data['off_date'] = date("Y-m-d H:i:s", strtotime("+" . BannersController::LIFETIME_BANNER));
//
//        $banner = new \Banners\Model\Banner();
//        $banner->exchangeArray($data);
//
//        $bannersTable = $this->getServiceLocator()->get('banners_table');
//        $bannersTable->saveBanner($banner);
//
//        return true;
//    }
}
