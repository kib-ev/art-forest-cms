<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class FavoriteController extends AbstractActionController
{
    public function indexAction()
    {
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute('application', array('action' => 'index'));
        }

        $favoriteTable = $this->getServiceLocator()->get('favorite_table');
        $favorites = $favoriteTable->fetchAllByUserId($userId);
        $postTable = $this->getServiceLocator()->get('post_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');

        return array(
            'attachmentTable' => $attachmentTable,
            'uploadfilemanager' => $uploadfilemanager,
            'favorites' => $favorites,
            'postTable' => $postTable,
        );
    }

    public function deleteAction()
    {
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $favoriteData = $request->getPost();
            $postId = (int) $favoriteData->post_id;
            if ($postId) {
                $favoriteTable = $this->getServiceLocator()->get('favorite_table');
                $favoriteTable->deleteFavorite($postId);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function favoriteAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        if (null === $user->getId()) {
            return $this->redirect()->toUrl('/users');
        }

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $postId = (int) $postData->id;
            if ($postId) {
                $favoriteTable = $this->getServiceLocator()->get('favorite_table');
                $value = $favoriteTable->favoritePost($postId, $user->getId());
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'value' => $value);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function listAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        if (null === $user->getId()) {
            return $this->redirect()->toUrl('/users');
        }

        $favoriteTable = $this->getServiceLocator()->get('favorite_table');
        $favorites = $favoriteTable->fetchAllByUserId($user->getId());
        $postTable = $this->getServiceLocator()->get('post_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');

        return array(
            'attachmentTable' => $attachmentTable,
            'uploadfilemanager' => $uploadfilemanager,
            'favorites' => $favorites,
            'postTable' => $postTable,
        );
    }

}