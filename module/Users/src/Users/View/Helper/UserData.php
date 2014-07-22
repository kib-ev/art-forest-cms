<?php

namespace Users\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Users\Model\UserDataTable;

class UserData extends AbstractHelper
{
    protected $userDataTable;

    public function __construct(UserDataTable $userDataTable)
    {
        $this->userDataTable = $userDataTable;
    }

    public function __invoke($user_id)
    {
        $userData = $this->userDataTable->getUserDataByUserId($user_id);
        if (empty($userData)) {
            $data = new \Users\Model\UserData();
            $data->user_id = $user_id;
            $this->userDataTable->saveUserData($data);

            $userData = $this->userDataTable->getUserDataByUserId($user_id);
        }
        return $userData;
    }

}