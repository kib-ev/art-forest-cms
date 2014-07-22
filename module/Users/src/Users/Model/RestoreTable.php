<?php

namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;
use Users\Model\RestoreEntity;

class RestoreTable
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

    public function getRestoreEntityById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();

        return $row ? $row : null;
    }

    public function getRestoreEntityByKey($key)
    {
        $rowset = $this->tableGateway->select(array('key' => $key));
        $row = $rowset->current();

        return $row ? $row : null;
    }

    public function getRestoreEntityByUserId($userId)
    {
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('userId' => $userId));
        $row = $rowset->current();

        return $row ? $row : null;
    }

    public function saveRestoreEntity(RestoreEntity $restoreEntity)
    {
        $data = array(
            'userId' => $restoreEntity->userId,
            'key' => $restoreEntity->key,
            'createDate' => $restoreEntity->createDate,
            'offDate' => $restoreEntity->offDate,
        );

        $id = (int) $restoreEntity->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRestoreEntityById($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                // exception
            }
        }
    }

}