<?php

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getUserById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function getUserByEmail($email) {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function saveUser(User $user) {

        $data = $user->getArrayCopy();
        unset($data['id']);

        $id = (int) $user->get('id');

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('user_id' => $id));
            }
        }
    }
}
