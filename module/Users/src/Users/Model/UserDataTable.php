<?php

namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;

class UserDataTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveUserData(\Users\Model\UserData $userData)
    {
        $data = array(
            'avatar_url' => $userData->avatar_url,
            'user_id' => $userData->user_id,
        );

        $user_id = (int) $userData->user_id;


        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();

        if (!$row) {
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, array('user_id' => $user_id));
        }

        return $this->getUserDataByUserId($userData->user_id);
    }

    public function getUserDataById($id)
    {
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();

        return $row;
    }

    public function getUserDataByUserId($user_id)
    {
        $user_id = (int) $user_id;


        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();

        if (!$row) {
            $userData = new \Users\Model\UserData();
            $userData->exchangeArray(array(
                'user_id' => $user_id,
            ));
            
            $this->saveUserData($userData);
            $this->getUserDataByUserId($user_id);
        }

        return $row;
    }

    public
            function deleteUserDataByUserId($user_id)
    {
        $user_id = (int) $user_id;
        $this->tableGateway->delete(array('user_id' => $user_id));
    }

}