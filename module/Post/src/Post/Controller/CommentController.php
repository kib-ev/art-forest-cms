<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\Comment;
use Post\Form\CommentForm;

class CommentController extends AbstractActionController
{
    public function indexAction()
    {
        $this->checkActivation(); //temp
        return array();
    }

    public function deleteAction()
    {
        $this->checkActivation(); //temp
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (null === $user->getId()) {
            return $this->redirect()->toUrl('/users');
        }
        $commentTable = $this->getServiceLocator()->get('comment_table');
        $postTable = $this->getServiceLocator()->get('post_table');

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            $postId = (int) $postData->post_id;
            $commentUser = $postTable->fetchById($postId);
            if ($id && $commentUser->getUserId() === $user->getId()) {
                $commentTable->deleteComment($id);
                $countComments = $commentTable->countComments($postId);
                $status = 'ok';
            } elseif ($id) {
                $commentTable->deleteCommentByUserId($id, $user->getId());
                $countComments = $commentTable->countComments($postId);

                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'countComments' => $countComments);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function saveAction()
    {
        $user = $this->getServiceLocator()->get('logged_in_user');
        if (!$this->getServiceLocator()->get('is_activated')) {//temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $id = (int) $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        if (null === $user->getId()) {
            return $this->redirect()->toUrl('/users');
        }

        $commentTable = $this->getServiceLocator()->get('comment_table');
        $commentForm = new CommentForm();
        $commentForm->setData(array('post_id' => $id));
        $request = $this->getRequest();

        if ($request->isPost()) {
            $comment = new Comment();
            $commentForm->setData($request->getPost());

            if ($commentForm->isValid()) {
                $comment->exchangeArray($commentForm->getData());
                $comment->setUserId($user->getId());

                $commentTable->saveComment($comment);

                return $this->redirect()->toUrl("/post/details/$id?scroll=down");
            }
        }
    }

}