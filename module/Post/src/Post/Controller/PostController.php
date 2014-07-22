<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Form\PostForm;
use Post\Model\Comment;
use Post\Form\CommentForm;
use Post\Model\Post;

class PostController extends AbstractActionController
{
    public function listAction()
    {
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

    public function deleteAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            if ($id) {
                $user = $this->getServiceLocator()->get('logged_in_user');
                $postTable = $this->getServiceLocator()->get('post_table');
                $favoriteTable = $this->getServiceLocator()->get('favorite_table');
                //delete post
                $postTable->deletePost($id, $user->getId());
                //delete favorites
                $favoriteTable->deleteFavorite($id);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'userid' => $user->getId());
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function addAction()
    {
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $user = $this->getServiceLocator()->get('logged_in_user');
        //add new, empty, not active post and redirect on edit page
        $postTable = $this->getServiceLocator()->get('post_table');
        $post = new Post();
        $post->setUserId($user->getId());
        $id = $postTable->savePost($post);
        return $this->redirect()->toUrl('/post/edit/' . $id[key($id)]);
    }

    public function editAction()
    {
        if (!$this->getServiceLocator()->get('is_activated')) { //temp
            return $this->redirect()->toUrl('/users/activate');
        }

        $user = $this->getServiceLocator()->get('logged_in_user');
        $file = null;
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');

        $post_id = (int) $this->params()->fromRoute('id', 0);

        if (!$post_id) {
            return $this->redirect()->toRoute('post', array('action' => 'add'));
        }
        $request = $this->getRequest();
        $postTable = $this->getServiceLocator()->get('post_table');
        $postForm = new PostForm();
        $post = $postTable->fetchByIdAndUserId($post_id, $user->getId());
        if (!$post) {
            return $this->redirect()->toRoute('application', array('action' => 'index'));
        }
        $postForm->bind($post);

        if ($request->isPost()) {
            if (empty($_FILES)) {
                $post = new Post();
                $postForm->setData($request->getPost());

                if ($postForm->isValid()) {
                    $post = $postForm->getData();
                    $post->setUserId($user->getId());
                    $post->setIsActive('1');
                    $this->addAddressFromUserToPost($post);

                    $postTable->savePost($post);
                    return $this->redirect()->toUrl('/post/details/' . $post_id);
                }
            } else {
                $countImages = $attachmentTable->countImages($post_id);
                $countFiles = $attachmentTable->countFiles($post_id);
                $filetype = substr($_FILES['file']['type'], 0, strpos($_FILES['file']['type'], '/'));
                if ($countImages <= 5 && $filetype == 'image') {
                    $file = $uploadfilemanager->saveFile($request, $user->getId());
                    $attachmentTable->saveAttachment($file->getId(), $post_id, $file->getType());
                } elseif ($countFiles <= 3 && $filetype != 'image') {
                    $file = $uploadfilemanager->saveFile($request, $user->getId());
                    $attachmentTable->saveAttachment($file->getId(), $post_id, $file->getType());
                }

                $response = $this->getResponse();
                if ($file) {
                    $answer = array(
                        'status' => 'ok',
                        'src' => $file->getFilepath(),
                        'upload_id' => $file->getId(),
                        'filename' => $file->getFilename(),
                    );
                    $response->setContent(\Zend\Json\Json::encode($answer));
                    $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
                    return $response;
                }
            }
        }
        $files = $attachmentTable->fetchAllByPostId($post_id);
        return array(
            'form' => $postForm,
            'id' => $post_id,
            'files' => $files,
            'uploadfilemanager' => $uploadfilemanager
        );
    }

    public function detailsAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $user = $this->getServiceLocator()->get('logged_in_user');

        $postTable = $this->getServiceLocator()->get('post_table');
        $likeTable = $this->getServiceLocator()->get('like_table');
        $commentTable = $this->getServiceLocator()->get('comment_table');

        //details for this post
        $post = $postTable->fetchById($id);
        //post comments
        $post_comments = $commentTable->fetchAllByPostId($id);

        //form
        $commentForm = new CommentForm();
        $commentForm->setData(array('post_id' => $id));

        //files
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        $uploadfilemanager = $this->getServiceLocator()->get('uploads_manager');
        $files = $attachmentTable->fetchAllByPostId($id);
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

    public function addAddressFromUserToPost($post) // todo temp method
    {
        $user = $this->getServiceLocator()->get('logged_in_user');

        $post->country = $user->country;
        $post->region = $user->region;
        $post->city = $user->city;
    }

    public function refreshAction()
    {
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

    public function tagsAction()
    {
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