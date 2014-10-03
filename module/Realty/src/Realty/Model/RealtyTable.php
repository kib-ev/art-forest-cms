<?php

namespace Realty\Model;

use Zend\Db\TableGateway\TableGateway;
use Realty\Model\Realty;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class RealtyTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

//    public function fetchAll() {
//
//        return $this->tableGateway->select(array('is_active' => '1'));
//    }

    public function getRealtysByUserId($userId) {
        return $this->tableGateway->select(array('user_id' => $userId));
    }

    public function deleteEmptyRealtysByUserId($userId) {
        $this->tableGateway->delete(
                array(
                    Realty::USER_ID => $userId,
                    Realty::TITLE => null,
                )
        );
    }

    public function deleteRealtyById($realtyId) {

        $this->tableGateway->delete(array('realty_id' => $realtyId));
    }

    public function getRealtyById($realtyId) {
        $realtyId = (int) $realtyId;
        $rowset = $this->tableGateway->select(array('realty_id' => $realtyId));
        $row = $rowset->current();
        return $row ? $row : null;
    }

    public function saveRealty(Realty $realty) {
        $data = $realty->getArrayCopy();

        unset($data['realty_id']);
        $realtyId = (int) $realty->get('realty_id');

        if ($realtyId == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRealtyById($realtyId)) {
                $this->tableGateway->update($data, array('realty_id' => $realtyId));
            }
        }
    }

    public function getLastUserRealty($userId) {
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($userId) {
            $select->where->
                    equalTo('user_id', $userId);
            $select->order('create_date DESC');
        });

        $row = $result->current();
        return $row ? $row : null;
    }

    public function fetchByIdAndUserId($realtyId, $userId) {
        $realtyId = (int) $realtyId;
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('realty_id' => $realtyId, 'user_id' => $userId));
        $row = $rowset->current();
        return $row;
    }

    public function fetchById($realtyId) {
        $realtyId = (int) $realtyId;
        $rowset = $this->tableGateway->select(array('realty_id' => $realtyId));
        $row = $rowset->current();
        return $row;
    }

    public function search($data) {

        \Application\Log\Logger::info(json_encode($data));
        $rowset = $this->tableGateway->select(function(Select $select) use ($data) {

            $title = $data['query'];
            if (!empty($title)) {
                $select->where->like('title', '%' . $title . '%');
            }

            $user_id = $data['user_id'];
            if (isset($user_id)) {
                $select->where->equalTo('user_id', $user_id);
            }
        });
        return $rowset ? $rowset : null;
    }

//    public function search_($input, $order_by, $order, $country = null, $region = null, $city = null) {
//
//        if ($city) {
//            $sql = "SELECT * FROM realtys WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region AND city=$city) ORDER BY $order_by $order LIMIT 100";
//        } elseif ($region) {
//            $sql = "SELECT * FROM realtys WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND (country=$country AND region=$region) ORDER BY $order_by $order LIMIT 100";
//        } elseif ($country) {
//            $sql = "SELECT * FROM realtys WHERE (title LIKE '%$input%' OR text LIKE '%$input%') AND country=$country ORDER BY $order_by $order LIMIT 100";
//        } else {
//            $sql = "SELECT * FROM realtys WHERE (title LIKE '%$input%' OR text LIKE '%$input%') ORDER BY $order_by $order LIMIT 100";
//        }
//
//        $rowset = $this->tableGateway->adapter->query($sql, array());
//        return $rowset;
//    }

    public function updateRealtyTime($id, $userId) {

        $data = array(
            'create_date' => \Users\DateTime\DateTime::getCurrentDateTimeString(),
        );


        $this->tableGateway->update(
                $data, array(
            'realty_id' => $id,
            'user_id' => $userId
                )
        );
    }

//    public function getRealtysByTags($tag) {
//        if ($tag != '') {
//            $select = new Select('realtys');
//            $select->where("tags LIKE '%{$tag}%' ")
//                    ->order('create_date DESC');
//
//            $resultSet = $this->tableGateway->selectWith($select);
//            return $resultSet;
//        }
//    }
}
