<?php

namespace Page\Model;

use Zend\Db\TableGateway\TableGateway;

class PageTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
      
        $result = $this->tableGateway->select(
                function (\Zend\Db\Sql\Select $select){

            $select->order('index ASC');
        });
        
        return $result;
    }

    public function getPageById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find page ID = $id");
        }
        return $row;
    }

    public function getPageByUrl($url)
    {
        $rowset = $this->tableGateway->select(array('url' => $url));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find page url = $url");
        }
        return $row;
    }

    public function savePage(\Page\Model\Page $page)
    {
        $data = array(
            'url' => $page->url,
            'user_id' => $page->user_id,
            'title' => $page->title,
            'body' => $page->body,
            'index' => $page->index,
            'create_date' => $page->create_date,
        );

        $id = (int) $page->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPageById($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception("Page ID = $id does not exist");
            }
        }

        return $this->getPageByUrl($page->url);
    }

    public function deletePageById($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function deletePageByUrl($url)
    {
        $this->tableGateway->delete(array('url' => $url));
    }

}