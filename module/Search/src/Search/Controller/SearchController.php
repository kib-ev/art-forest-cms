<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SearchController extends AbstractActionController {

    public function displayAction() {
        return $this->redirect()->toUrl('search/index');
    }

    public function indexAction() {
        $query = $this->params()->fromQuery('query');
        \Application\Log\Logger::info('query=' . $query);


        $postTable = $this->getServiceLocator()->get('post_table');
        $searchResults = $postTable->searchAjax($query);


        return array(
            'query' => $query,
//            'uploadFileManager' => $uploadFileManager,
            'searchResults' => $searchResults,
//            'attachmentTable' => $attachmentTable,
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
                            <a class="search-link" href="/post/details/' . $searchResult->id . '">' . $highlight_word . '</a>
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
