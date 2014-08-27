<?php

namespace Dialog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Update;

class DialogTable {

    protected $tableGateway;
    protected $tableName;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
        $this->tableName = $tableGateway->getTable();
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getDialogsByUserId($id) {
        $sql = "SELECT * FROM $this->tableName
                    WHERE dialog_id IN ( 
                        SELECT MAX(dialog_id) dialog_id FROM (
                            SELECT MAX(dialog_id) dialog_id, recipient_id touser_id 
                                FROM $this->tableName 
                                WHERE sender_id = $id 
                                GROUP By recipient_id
                            UNION ALL
                            SELECT MAX(dialog_id) dialog_id, sender_id
                                FROM $this->tableName
                                WHERE recipient_id = $id     
                                GROUP BY sender_id ) g    
                            GROUP BY touser_id) 
                     ORDER BY create_date ASC ;  
                ";



        $rowset = $this->tableGateway->getAdapter()->query($sql, array());

        if (!$rowset) {
            throw new \Exception("Could not find dialogs for user ID[$id]");
        }

        return $rowset;
    }

    public function getNewDialogsCountByUserId($id) {
        $sql = "SELECT DISTINCT sender_id FROM $this->tableName 
                WHERE recipient_id = $id   
                    AND is_new = 1"; // to do


        $rowset = $this->tableGateway->getAdapter()->query($sql, array());

        if (!$rowset) {
            throw new \Exception("Could not find dialogs for user ID[$id]");
        }

        return $rowset;
    }

    public function getDialogsForUsers($currentUserId, $selectedUserId) {
        $this->tableGateway->update(
                array('is_unread' => 0), array('recipient_id' => $currentUserId, 'sender_id' => $selectedUserId)
        );

        $rowset = $this->tableGateway->select(
                function (Select $select) use ($currentUserId, $selectedUserId) {

            $select->where->
                    equalTo('sender_id', $currentUserId)->
                    equalTo('recipient_id', $selectedUserId)->
                    or->
                    equalTo('sender_id', $selectedUserId)->
                    equalTo('recipient_id', $currentUserId);
        });

        return $rowset ? $rowset : null;
    }

    public function saveDialog(Dialog $dialog) {
        $data = $dialog->getArrayCopy();

        $dialog_id = (int) $dialog->get('dialog_id');

        if ($dialog_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, array('dialog_id' => $dialog_id));
        }
    }

    public function deleteDialog($id) {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function deleteUsersDialogs($currentUserId, $selectedUserId) {
//        $this->tableGateway->update(array('deleted_by_user_id' => '-1'), array(
//            new \Zend\Db\Sql\Predicate\IsNotNull('deleted_by_user_id'),
//            new \Zend\Db\Sql\Predicate\Operator('deleted_by_user_id', \Zend\Db\Sql\Predicate\Operator::OPERATOR_NOT_EQUAL_TO, $curentUserId),
//            'recipient_id' => $curentUserId,
//            'sender_id' => $selectedUserId)
//        );
//
//        $this->tableGateway->update(array('deleted_by_user_id' => '-1'), array(
//            new \Zend\Db\Sql\Predicate\IsNotNull('deleted_by_user_id'),
//            new \Zend\Db\Sql\Predicate\Operator('deleted_by_user_id', \Zend\Db\Sql\Predicate\Operator::OPERATOR_NOT_EQUAL_TO, $curentUserId),
//            'recipient_id' => $selectedUserId,
//            'sender_id' => $curentUserId)
//        );

        $this->tableGateway->delete(array(new \Zend\Db\Sql\Predicate\IsNotNull('deleted_by_user_id'),
            new \Zend\Db\Sql\Predicate\Operator('deleted_by_user_id', \Zend\Db\Sql\Predicate\Operator::OPERATOR_NOT_EQUAL_TO, $currentUserId),
            'recipient_id' => $currentUserId,
            'sender_id' => $selectedUserId));

        $this->tableGateway->delete(array(new \Zend\Db\Sql\Predicate\IsNotNull('deleted_by_user_id'),
            new \Zend\Db\Sql\Predicate\Operator('deleted_by_user_id', \Zend\Db\Sql\Predicate\Operator::OPERATOR_NOT_EQUAL_TO, $currentUserId),
            'recipient_id' => $selectedUserId,
            'sender_id' => $currentUserId));

        $this->tableGateway->update(array('deleted_by_user_id' => $currentUserId,
            'is_new' => 0), array(
            new \Zend\Db\Sql\Predicate\IsNull('deleted_by_user_id'),
            'recipient_id' => $currentUserId,
            'sender_id' => $selectedUserId)
        );

        $this->tableGateway->update(array('deleted_by_user_id' => $currentUserId,
            'is_new' => 0), array(
            new \Zend\Db\Sql\Predicate\IsNull('deleted_by_user_id'),
            'recipient_id' => $selectedUserId,
            'sender_id' => $currentUserId)
        );


//        $this->tableGateway->delete(
//                function (Delete $delete) use ($curentUserId, $selectedUserId) {
//
//            $delete->where->
//                    equalTo('sender_id', $curentUserId)->
//                    equalTo('recipient_id', $selectedUserId)->
//                    or->
//                    equalTo('sender_id', $selectedUserId)->
//                    equalTo('recipient_id', $curentUserId);
//        });
    }
}
