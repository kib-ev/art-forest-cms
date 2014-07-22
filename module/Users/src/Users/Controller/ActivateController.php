<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ActivateController extends AbstractActionController
{
    public function indexAction()
    {
        if ($this->getServiceLocator()->get('is_activated')) {
            $id = $this->getServiceLocator()->get('logged_in_user')->user_id;
            $this->redirect()->toUrl("/post/list/$id");
        }
        return array();
    }

    public function controlAction()
    {
        $userTable = $this->getServiceLocator()->get('users_table');
        // todo check admin

        if (isset($_GET['unp'])) {
            $unp = (int) $_GET['unp'];

            $this->toggleUserState();

            $this->changeDateOff();

            $users = $userTable->getUsersByUnp($unp);


            if (isset($_GET['term'])) {
                $this->redirect()->toUrl("/users/activate/control?unp=$unp");
            }

            return array(
                'users' => $users,
                'unp' => $unp
            );
        }
    }

    private function toggleUserState()
    {
        $userTable = $this->getServiceLocator()->get('users_table');

        if (isset($_GET['state']) && isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $user = $userTable->getUserById($id);

            if ($user) {



                if ($_GET['state'] == 'on') {
                    $userTable->setStateToUserById($id, \Users\Model\User::STATE_ACTIVATED);
                } else if ($_GET['state'] == 'off') {
                    $userTable->setStateToUserById($id, \Users\Model\User::STATE_NOT_ACTIVATED);
                }
            }
        }
    }

    public function changeDateOff()
    {
        $userTable = $this->getServiceLocator()->get('users_table');

        if (isset($_GET['term']) && isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $user = $userTable->getUserById($id);

            if ($user) {

                $offDate = new \DateTime($user->off_date);

                if ($_GET['term'] == 'reduce') {
                    date_modify($offDate, '-30 days');
                } else if ($_GET['term'] == 'increase') {
                    date_modify($offDate, '+30 days');
                }

                $user->off_date = date_format($offDate, 'Y-m-d H:i:s');
                $currentDate = \Users\DateTime\DateTime::getCurrentDateTime();

                \Application\Log\Logger::info($offDate->getTimestamp());
                \Application\Log\Logger::info($currentDate->getTimestamp());

                $intOffDate = (int) $offDate->getTimestamp();
                $intCurrDate = (int) $currentDate->getTimestamp();

                if ($intOffDate < $intCurrDate) {
                    \Application\Log\Logger::info('<');
                    $user->state = \Users\Model\User::STATE_NOT_ACTIVATED;
                }

                if ($intOffDate > $intCurrDate) {
                    \Application\Log\Logger::info('>');
                    $user->state = \Users\Model\User::STATE_ACTIVATED;
                }

                $user->password = md5($user->clear_password);
                $userTable->saveUser($user);
            }
        }
    }

}