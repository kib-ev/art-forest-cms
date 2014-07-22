<?php

namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        return $this->getUserById($id);
    }

    public function getUserById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $row = $rowset->current();

        if (!$row) {
            \Application\Log\Logger::err("UsersTable: could not find user($id)");
        }

        return $row;
    }

    public function getUserByEmail($email)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        if (!$row) {
            \Application\Log\Logger::err("UsersTable: user ($email) does not exist");
        }
        return $row;
    }

    public function getUsersByUnp($unp)
    {
        $unp = (int) $unp;
        $rowset = $this->tableGateway->select(
                array(
                    'unp' => $unp,
                )
        );
        return $rowset;
    }

    public function setStateToUserById($id, $state)
    {
        $id = (int) $id;
        $this->tableGateway->update(
                array(
            'state' => $state,
                ), array(
            'user_id' => $id
        ));

        if ($state == \Users\Model\User::STATE_ACTIVATED) {
            $this->tableGateway->update(
                    array(
                'off_date' => date("Y-m-d H:i:s", strtotime('+3 hours')),
                    ), array(
                'user_id' => $id,
                'off_date' => null,
            ));
        }
    }

    public function saveUser(User $user)
    {
        $data = array(
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'clear_password' => $user->clear_password,
            'display_name' => $user->display_name,
            'role_id' => $user->role_id,
            'create_date' => $user->create_date,
            'off_date' => $user->off_date,
            'state' => $user->state,
            'reg_type' => $user->reg_type,
            'org_name' => $user->org_name,
            'position' => $user->position,
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'country' => $user->country,
            'city' => $user->city,
            'region' => $user->region,
            'street' => $user->street,
            'house' => $user->house,
            'office' => $user->office,
            'phone' => $user->phone,
            'unp' => $user->unp,
            'egr_org' => $user->egr_org,
            'egr_num' => $user->egr_num,
            'egr_date' => $user->egr_date,
            'bank' => $user->bank,
            'bank_code' => $user->bank_code,
            'bank_address' => $user->bank_address,
            'bank_acc' => $user->bank_acc,
        );

        $id = (int) $user->getId();

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('user_id' => $id));
            } else {
                \Application\Logger\Logger::err("UsersTable: user($id) does not exist");
            }
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('user_id' => $id));
    }

    public function updateUserClearPassword($id, $clear_password)
    {
        \Application\Log\Logger::info('user ' . $id . ' pass ' . $clear_password);
        $this->tableGateway->update(
                array(
            'clear_password' => $clear_password,
                ), array(
            'user_id' => $id)
        );
    }

}