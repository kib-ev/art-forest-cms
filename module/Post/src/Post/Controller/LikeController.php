<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LikeController extends AbstractActionController
{
    public function indexAction()
    {
        $this->checkActivation(); //temp
        return array();
    }

    public function likeAction()
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
            $post_id = (int) $postData->id;
            if ($post_id) {
                $likeTable = $this->getServiceLocator()->get('like_table');
                $likeTable->likePost($post_id, $user->getId());
                $countLikes = $likeTable->countLikes($post_id);
                $value = $likeTable->getByUserIdAndPostId($post_id, $user->getId());
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'countLikes' => $countLikes, 'value' => $value);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

}