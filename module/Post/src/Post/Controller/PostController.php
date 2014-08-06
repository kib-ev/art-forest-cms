<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Form\PostForm;
use Post\Model\Comment;
use Post\Form\CommentForm;
use Post\Model\Post;

class PostController extends AbstractActionController {

    public function listAction() {
        $selectUserId = $this->params()->fromRoute('id');

        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');
         
        if (empty($selectUserId)) {
            return $this->redirect()->toUrl("/post/list/$userId");
        }
        $selectUserId = (int) $selectUserId;

        $sm = $this->getServiceLocator();
        $postTable = $sm->get('post_table');
        $posts = $postTable->getPostsByUserId($selectUserId);

        return array('posts' => $posts);
    }

    public function listAction_() {
        //UserId from route!
        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute('application', array('action' => 'index'));
        }

        $favoriteTable = $this->getServiceLocator()->get('favorite_table');
        $userTable = $this->getServiceLocator()->get('users_table');
        $postTable = $this->getServiceLocator()->get('post_table');
        $likeTable = $this->getServiceLocator()->get('like_table');
        $commentTable = $this->getServiceLocator()->get('comment_table');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');

        $userExist = $userTable->getUserById($userId);
        if (!$userExist) {
            return $this->redirect()->toRoute('application', array('action' => 'index'));
        }

        $posts = $postTable->fetchAllByUserId($userId);
        $users = $userTable->getUser($userId);
        return array(
            'count' => $posts->count(),
            'posts' => $posts,
            'users' => $users,
            'likeTable' => $likeTable,
            'commentTable' => $commentTable,
            'favoriteTable' => $favoriteTable,
            'attachmentTable' => $attachmentTable,
            'uploadfilemanager' => $uploadfilemanager
        );
    }

    public function deleteAction() {
        $sm = $this->getServiceLocator();

        $postId = (int) $this->params()->fromRoute('id');

        $userId = $sm->get('logged_in_user_id');
        $postTable = $sm->get('post_table');
        $post = $postTable->getPostById($postId);

        if ($post && $post->get('userId') != $userId) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $postTable->deletePostById($postId);
        return $this->redirect()->toUrl("/post/list/$userId");
    }

    public function addAction() {
        $form = new \Post\Form\PostForm();
        $inputFilter = new \Post\Form\PostInputFilter();
        $form->setInputFilter($inputFilter);

        return array(
            'form' => $form,
        );
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/post/add');
        }

        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $data = $this->request->getPost();

        $form = new \Post\Form\PostForm();
        $inputFilter = new \Post\Form\PostInputFilter();
        $form->setInputFilter($inputFilter);

        $form->setData($data);

        if (!$form->isValid()) { // todo valid form
            $view = new \Zend\View\Model\ViewModel();
            $view->setTemplate('/post/post/add');
            $view->setVariable('form', $form);

            return $view;
        } else {
            $data['createDate'] = time();
            $data['userId'] = $userId;

            $post = new \Post\Model\Post();
            $post->exchangeArray($data);

            $postTable = $sm->get('post_table');
            $postTable->savePost($post);

            $postId = $postTable->getLastUserPost($userId)->get('id');

            return $this->redirect()->toUrl("/post/view/$postId");
        }
    }

    public function editAction() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $postId = (int) $this->params()->fromRoute('id');

        if (!$postId) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $postTable = $sm->get('post_table');
        $post = $postTable->getPostById($postId);

        if (!$post || $post->get('userId') != $userId) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $postForm = new PostForm();
        $postForm->bind($post);

        return array(
            'form' => $postForm,
            'postId' => $postId,
        );
    }

    public function detailsAction() {
        $postId = (int) $this->params()->fromRoute('id');
        if (!$postId) {
            return $this->redirect()->toRoute('post');
        }

        $user = $this->getServiceLocator()->get('logged_in_user');

        $postTable = $this->getServiceLocator()->get('post_table');
        $likeTable = $this->getServiceLocator()->get('like_table');
        $commentTable = $this->getServiceLocator()->get('comment_table');

        //details for this post
        $post = $postTable->fetchById($postId);
        //post comments
        $post_comments = $commentTable->fetchAllByPostId($postId);

        //form
        $commentForm = new CommentForm();
        $commentForm->setData(array('post_id' => $postId));

        //files
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $files = $attachmentTable->fetchAllByPostId($postId);
        return array(
            'post' => $post,
            'user' => $user,
            'post_comments' => $post_comments,
            'form' => $commentForm,
            'likeTable' => $likeTable,
            'commentTable' => $commentTable,
            'files' => $files,
            'uploadfilemanager' => $uploadfilemanager
        );
    }

    public function viewAction() {
        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $postId = (int) $this->params()->fromRoute('id');

        if (!$postId) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $postTable = $sm->get('post_table');
        $post = $postTable->getPostById($postId);

        if (!$post) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return array(
            'post' => $post,
            'userId' => $userId,
        );
    }

    public function addAddressFromUserToPost($post) { // todo temp method
        $user = $this->getServiceLocator()->get('logged_in_user');

        $post->country = $user->country;
        $post->region = $user->region;
        $post->city = $user->city;
    }

    public function refreshAction() {
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $user = $this->getServiceLocator()->get('logged_in_user');
        $postTable = $this->getServiceLocator()->get('post_table');

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            if ($id) {
                $postTable->updatePostTime($id, $user->getId());
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'date' => date("Y-m-d H:i", strtotime('+3 hours')));
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function tagsAction() {
        //echo 'tag';
        $tag = $_GET['t'];

        $favoriteTable = $this->getServiceLocator()->get('favorite_table');
        $userTable = $this->getServiceLocator()->get('users_table');
        $postTable = $this->getServiceLocator()->get('post_table');
        $likeTable = $this->getServiceLocator()->get('like_table');
        $commentTable = $this->getServiceLocator()->get('comment_table');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');

        /* $userExist = $userTable->getUserById($userId);
          if (!$userExist) {
          return $this->redirect()->toRoute('application', array('action' => 'index'));
          } */

        $posts = $postTable->getPostsByTags('#' . $tag);
        $users = $this->getServiceLocator()->get('logged_in_user');
        return array(
            'count' => $posts->count(),
            'posts' => $posts,
            'users' => $users,
            'likeTable' => $likeTable,
            'commentTable' => $commentTable,
            'favoriteTable' => $favoriteTable,
            'attachmentTable' => $attachmentTable,
            'uploadfilemanager' => $uploadfilemanager
        );
    }
}
