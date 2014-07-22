<?php

namespace Banners\Model;

use Zend\Db\TableGateway\TableGateway;

class BannersTable
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

    public function saveBanner(\Banners\Model\Banner $banner)
    {
        $data = array(
            'user_id' => (int) $banner->user_id,
            'image_id' => (int) $banner->image_id,
            'image' => $banner->image,
            'type' => $banner->type,
            'url' => $banner->url,
            'title' => $banner->title,
            'cost' => $banner->cost,
            'sale' => $banner->sale,
            'hits' => $banner->hits,
            'create_date' => $banner->create_date,
            'off_date' => $banner->off_date,
            'is_on' => $banner->is_on,
            'status' => $banner->status,
        );

        $id = (int) $banner->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBannerById($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception("Banner ID does not exist");
            }
        }

        return $this->getBannerByTypeForUser($banner->type, $banner->user_id);
    }

    public function getBannerById($id)
    {
        $result = $this->tableGateway->select(array('id' => $id));
        return $result->current();
    }

    public function getRandomBannerByType($type)
    {
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($type) {

            $select->where->
                    equalTo('type', $type)->
                    notEqualTo('image', '')->
                    equalTo('is_on', TRUE);
            $select->order(new \Zend\Db\Sql\Expression('rand()'));
        });

        if ($result) {
            return $result->current();
        }
        return null;
    }

    public function getRandomBannersByTypeLimit($type, $limit)
    {
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($type, $limit) {

            $select->where->
                    equalTo('type', $type)->
                    notEqualTo('image', '')->
                    equalTo('is_on', TRUE);
            $select->order(new \Zend\Db\Sql\Expression('rand()'));
            $select->limit($limit);
        });

        if ($result->count() < $limit) {
            return $result;
        } else {
            return $result;
        }

        return null;
    }

    public function getBannerByTypeForUser($type, $user_id)
    {
        \Application\Log\Logger::info('getBannerByTypeForUser');
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($type, $user_id) {

            $select->where->
                    equalTo('type', $type)->
                    equalTo('user_id', $user_id);
            $select->order('id DESC');
        });

        if ($result->count() > 0) {
            \Application\Log\Logger::info('>0');
            return $result->current();
        }
        return null;
    }

    public function getBannersByTypeForUser($type, $user_id)
    {

        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select) use ($type, $user_id) {

            $select->where->
                    equalTo('type', $type)->
                    equalTo('user_id', $user_id);
            $select->order('id DESC');
        });

        return $result;
    }

    public function getBanner($id)
    {
        $result = $this->tableGateway->select(array('id' => $id));
        return $result->current();
    }

}
