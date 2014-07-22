<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//
use ZendSearch\Lucene;
use ZendSearch\Lucene\Document;
//
use ZendSearch\Lucene\Analysis\Analyzer\Analyzer;
use ZendSearch\Lucene\Search\QueryParser;
use ZendSearch\Lucene\Analysis\Analyzer\Common\Utf8Num\CaseInsensitive;
use Zend\Db\Sql\Select;
use Zend\View\Helper\EscapeHtml;

class SearchController extends AbstractActionController {

    protected $options;

    public function displayAction() {
        return $this->redirect()->toUrl('search/index');
    }

    public function indexAction() {
        Analyzer::setDefault(new CaseInsensitive());
        QueryParser::setDefaultEncoding('utf-8');

        $uploadFileManager = $this->getServiceLocator()->get('uploads_manager');
        $attachmentTable = $this->getServiceLocator()->get('attachment_table');
        $request = $this->getRequest();

        if ($request->isPost()) {

            $queryText = $request->getPost()->get('query');
            $postTable = $this->getServiceLocator()->get('post_table');

            $country = $request->getPost()->get('country');
            $region = $request->getPost()->get('region');
            $city = $request->getPost()->get('city');

            if (isset($_COOKIE['ardfo_fltr_cnt_id'])) {
                $country = $_COOKIE['ardfo_fltr_cnt_id'];
            }
            if (isset($_COOKIE['ardfo_fltr_rgn_id'])) {
                $region = $_COOKIE['ardfo_fltr_rgn_id'];
            }
            if (isset($_COOKIE['ardfo_fltr_cty_id'])) {
                $city = $_COOKIE['ardfo_fltr_cty_id'];
            }

            $order_by = $request->getPost()->get('order_by') ?
                    $request->getPost()->get('order_by') : 'create_date';

            $order = $request->getPost()->get('order') ?
                    $request->getPost()->get('order') : Select::ORDER_DESCENDING;
            //request in db
            $searchResults = $postTable->search($queryText, $order_by, $order, $country, $region, $city);
            
            
            return array(
                'query' => $queryText,
                'uploadFileManager' => $uploadFileManager,
                'searchResults' => $searchResults,
                'attachmentTable' => $attachmentTable,
            );
        }
        $searchResults = array();
        return array(
            'uploadFileManager' => $uploadFileManager,
            'searchResults' => $searchResults,
            'attachmentTable' => $attachmentTable,
        );
    }

    public function filterAction() {
        
    }

    public function getIndexLocation() {
        $config = $this->getServiceLocator()->get('config');

        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        if (!empty($config['module_config']['search_index'])) {
            return $config['module_config']['search_index'];
        } else {
            return FALSE;
        }
    }

    public function updateAction() {
        Analyzer::setDefault(new CaseInsensitive());
        QueryParser::setDefaultEncoding('utf-8');

        $searchIndexLocation = $this->getIndexLocation();
        $index = Lucene\Lucene::create($searchIndexLocation);

        $dbTableName = $this->getOptions()->getDbTable();
        $dbTable = $this->getServiceLocator()->get($dbTableName);
        $data = $dbTable->fetchAll();

        foreach ($data as $row) {

            $fields = $this->getOptions()->getFields();

            $indexDoc = new Lucene\Document();

            do {
                $fieldName = key($fields);
                $params = current($fields);

                $isIndexed = $params['isIndexed'] ? true : false;
                $isStored = $params['isStored'] ? true : false;
                $isTokenized = $params['isTokenized'] ? true : false;
                $encoding = isset($params['encoding']) ? $params['encoding'] : 'UTF-8';
                $boost = isset($params['boost']) ? $params['boost'] : 1;

                $rowAsArray = $row->getArrayCopy();

                $rowFieldName = $params['fieldName'];
                $value = $rowAsArray[$rowFieldName];

                $luceneField = new Document\Field($fieldName, $value, $encoding, $isIndexed, $isStored, $isTokenized);
                $luceneField->boost = $boost;

                $indexDoc->addField($luceneField);
            } while ((next($fields)));

            $index->addDocument($indexDoc);
        }
        $index->optimize();
        $index->commit();
    }

    private function getOptions() {
        if (null === $this->options) {
            $this->options = $this->getServiceLocator()->get('search_module_options');
        }

        return $this->options;
    }

    public function listAction() {
        Analyzer::setDefault(new CaseInsensitive());
        QueryParser::setDefaultEncoding('utf-8');

        $postTable = $this->getServiceLocator()->get('post_table');

        $request = $this->getRequest();
        $response = $this->getResponse();

        $searchResults = array();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $queryText = $postData->q;
            $searchResults = $postTable->searchAjax($queryText);
        }

        if ($searchResults->count()) {
            
            foreach ($searchResults as $searchResult) {
                $highlight_word = preg_replace('/' . $queryText . '/ui', '<span class="highlight">\\0</span>', $searchResult->title);

                echo '
                        <li class="element-result">
                            <div class="block-title-price">
                            <a class="search-link" href="/post/details/' . $searchResult->id . '">'.$highlight_word.'</a>
                            </div>
                        </li>
                    ';
            }
            return $response;
        } else {
                  
        }
        return $response;
    }
    
}
