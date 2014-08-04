<?php

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * 
     * @param int $userId
     * @return \Zend\Db\ResultSet\ResultSet $row or null
     */
    public function getUserById($userId) {
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('id' => $userId));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    /**
     * 
     * @param text $email
     * @return \Zend\Db\ResultSet\ResultSet $row or null
     */
    public function getUserByEmail($email) {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    /**
     * 
     * @param \User\Model\User $user
     */
    public function saveUser(User $user) {
        $data = $user->getArrayCopy();

        unset($data['id']);
        $userId = (int) $user->get('id');

        if ($userId == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUserById($userId)) {
                $this->tableGateway->update($data, array('id' => $userId));
            }
        }
    }
}
