<?php

namespace Users;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Users\Acl\Acl;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //$eventManager->attach('route', array($this, 'onRoute'), -100);
    }

    public function onRoute(\Zend\EventManager\EventInterface $e)
    { // Event manager of the app
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager();
        $auth = $sm->get('zend_auth_service');
        $acl = $sm->get('acl');
        // everyone is guest until logging in
        $role = Acl::DEFAULT_ROLE; // The default role is guest $acl

        if ($auth->hasIdentity()) {
            $user = $auth->getStorage()->read();

            if ($user->role_id == 2) {
                $role = 'member';
            } else if ($user->role_id == 3) {
                $role = 'admin';
            } else if ($user->role_id == 4) {
                $role = 'user';
            }
        }

        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');

        if (!$acl->hasResource($controller)) {
            throw new \Exception('Resource ' . $controller . ' not defined');
        }

        if (!$acl->isAllowed($role, $controller, $action)) {

            $response = $e->getResponse();
            $config = $sm->get('config');
            $redirect_route = $config['acl']['redirect_route'];
            if (!empty($redirect_route)) {

                if ($role == 'user') {
                    $url = $e->getRouter()->assemble(
                            array(
                        'controller' => 'users',
                            ), array(
                        'name' => 'users/activate',
                    ));
                } else {
                    $url = $e->getRouter()->assemble(
                            array(
                        'controller' => 'users',
                            ), array(
                        'name' => 'users/register',
                    ));
                }

                $response->getHeaders()->addHeaderLine('Location', $url);



                // The HTTP response status code 302 Found is a common way of performing a redirection.
                // http://en.wikipedia.org/wiki/HTTP_302
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            } else {
                //Status code 403 responses are the result of the web server being configured to deny access,
                //for some reason, to the requested resource by the client.
                //http://en.wikipedia.org/wiki/HTTP_403
                $response->setStatusCode(403);
                $response->setContent('
                    <html>
                        <head>
                            <title>403 Forbidden</title>
                        </head>
                        <body>
                            <h1>403 Forbidden</h1>
                        </body>
                    </html>'
                );
                return $response;
            }
        }
    }

    protected function getRoleNameById()
    {
        
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array('users_table_gateway' => function ($sm) {
            $dbAdapter = $sm->get('zend_db_adapter');
            $resultSetPrototype = new ResultSet();
            $user = new \Users\Model\User();
            $resultSetPrototype->setArrayObjectPrototype($user);
            $usersTableGateway = new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
            return $usersTableGateway;
        }, 'users_table' => function ($sm) {
            $usersTableGateway = $sm->get('users_table_gateway');
            $usersTable = new \Users\Model\UsersTable($usersTableGateway);
            return $usersTable;
        }, 'restore_table_gateway' => function ($sm) {
            $dbAdapter = $sm->get('zend_db_adapter');
            $resultSetPrototype = new ResultSet();
            $restoreEntity = new \Users\Model\RestoreEntity();
            $resultSetPrototype->setArrayObjectPrototype($restoreEntity);
            $restoreTableGateway = new TableGateway('restore', $dbAdapter, null, $resultSetPrototype);
            return $restoreTableGateway;
        }, 'restore_table' => function ($sm) {
            $restoreTableGateway = $sm->get('restore_table_gateway');
            $restoreTable = new \Users\Model\RestoreTable($restoreTableGateway);
            return $restoreTable;
        },
                // forms
                'RegisterForm' => function ($sm) {
            $form = new \Users\Form\RegisterForm();
            $form->setInputFilter($sm->get('RegisterFormFilter'));
            return $form;
        },
                'LoginForm' => function ($sm) {
            $form = new \Users\Form\LoginForm();
            $form->setInputFilter($sm->get('LoginFormFilter'));
            return $form;
        },
                'UserEditForm' => function ($sm) {
            $form = new \Users\Form\UserEditForm();
            $form->setInputFilter($sm->get('UserEditFormFilter'));
            return $form;
        },
                // form filters
                'RegisterFormFilter' => function ($sm) {
            $filter = new \Users\Form\RegisterFormFilter();
            return $filter;
        },
                'LoginFormFilter' => function ($sm) {
            $filter = new \Users\Form\LoginFormFilter();
            return $filter;
        },
                'UserEditFormFilter' => function ($sm) {
            $filter = new \Users\Form\UserEditFormFilter();
            return $filter;
        },
                /* auth service */
//                'zend_auth_service' => function ($sm) {
//            $dbAdapter = $sm->get('zend_db_adapter');
//            $dbTableAuthAdapter = new \Zend\Authentication\Adapter\DbTable($dbAdapter, 'user', 'email', 'password', ''); // md5(?)
//            $authService = new \Zend\Authentication\AuthenticationService();
//            $authService->setAdapter($dbTableAuthAdapter);
//            return $authService;
//        },
                /* get current logged in user */
                'logged_in_user' => function ($sm) {
            $authService = $sm->get('zend_auth_service');
            $user = $authService->getStorage()->read();
            return isset($user) ? $user : new \Users\Model\User();
        },
                'is_activated' => function ($sm) {
            $loggedInUser = $sm->get('logged_in_user');
            $userId = $loggedInUser->user_id;
            $userTable = $sm->get('users_table');
            $user = $userTable->getUserById($userId);

            if ($user->state == \Users\Model\User::STATE_NOT_ACTIVATED) {
                return false;
            } else {
                return true;
            }
        },
                'acl' => function ($sm) {
            $config = $sm->get('config');
            return new \Users\Acl\Acl($config);
        },
                'user_data_table_gateway' => function ($sm) {
            $dbAdapter = $sm->get('zend_db_adapter');
            $resultSetPrototype = new ResultSet();
            $userData = new \Users\Model\UserData();
            $resultSetPrototype->setArrayObjectPrototype($userData);
            $userDataTableGateway = new TableGateway('user_data', $dbAdapter, null, $resultSetPrototype);
            return $userDataTableGateway;
        },
                'user_data_table' => function ($sm) {
            $userDataTableGateway = $sm->get('user_data_table_gateway');
            $userDataTable = new \Users\Model\UserDataTable($userDataTableGateway);
            return $userDataTable;
        },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'getUserHelper' => function($vhm) {
            $sm = $vhm->getServiceLocator();
            return new \Users\View\Helper\UserHelper($sm->get('logged_in_user'));
        },
                'getUserData' => function($vhm) {
            $sm = $vhm->getServiceLocator();
            $userDataTable = $sm->get('user_data_table');
            return new \Users\View\Helper\UserData($userDataTable);
        },
            ),
        );
    }

}