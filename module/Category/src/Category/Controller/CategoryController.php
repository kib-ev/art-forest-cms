<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController {

    public function indexAction() {
        return $this->redirect()->toUrl("/category/list");
    }

    public function listAction() {
        $categoryKeyId = $this->params()->fromQuery('category_id');
        return array(
            'categoryKeyId' => $categoryKeyId,
        );
    }

    public function addAction() {
        $sm = $this->getServiceLocator();

        $userId = $sm->get('logged_in_user_id');

        $data = array(
            'user_id' => $userId,
            'create_date' => time(),
        );

        $categoryTable = $sm->get('category_table');

        $categoryEntity = new \Category\Model\Category($data);
        $categoryTable->saveCategory($categoryEntity);

        $savedCategory = $categoryTable->getLastUserCategory($userId);
        $savedCategoryId = $savedCategory->get('category_id');

        return $this->redirect()->toUrl("/category/edit/$savedCategoryId");
    }

    public function addKeyAction() {
        $sm = $this->getServiceLocator();

        $userId = $sm->get('logged_in_user_id');

        $data = array(
            'user_id' => $userId,
            'create_date' => time(),
        );

        $categoryTable = $sm->get('category_table');

        $categoryEntity = new \Category\Model\Category($data);
        $categoryTable->saveCategory($categoryEntity);

        $savedCategory = $categoryTable->getLastUserCategory($userId);
        $savedCategoryId = $savedCategory->get('category_id');

        return $this->redirect()->toUrl("/category/edit/$savedCategoryId");
    }

    public function editAction() {
        $categoryId = (int) $this->params()->fromRoute('id');

        return array(
            'categoryId' => $categoryId,
        );
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toUrl('/category/add');
        }

        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $data = $this->request->getPost();

        \Application\Log\Logger::info(json_encode($data));

        $form = $sm->get('Category\Form\CategoryForm');
        $form->setData($data);

        $categoryId = $data['category_id'];

        if (!$form->isValid()) { // todo valid form
            \Application\Log\Logger::info('FORM CATEGORY NOT VALID');
            $formMessages = $form->getMessages();
            $this->flashMessenger()->setNamespace($form->getName())->addMessage($formMessages);
            return $this->redirect()->toUrl("/category/edit/$categoryId");
        } else {
            $data['create_date'] = time();
            $data['user_id'] = $userId;

            $category = new \Category\Model\Category();
            $category->exchangeArray($data);

            $categoryTable = $sm->get('category_table');
            $categoryTable->saveCategory($category);

            $lastCategory = $categoryTable->getLastUserCategory($userId);
            $categoryId = $lastCategory->get('category_id');

            return $this->redirect()->toUrl($data['redirect']);
        }
    }

    public function deleteAction() {
        $sm = $this->getServiceLocator();
        $categoryId = (int) $this->params()->fromRoute('id');
        $categoryTable = $sm->get('category_table');
        $categoryTable->deleteCategoryById($categoryId);
        return $this->redirect()->toUrl("/category");
    }

}
