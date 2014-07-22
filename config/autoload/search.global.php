<?php

return array(
    'zend_search_lucene' => array(
        'db_table' => 'post_table', // alias which return PostTable instance
        'fields' => array(
            'post_id' => array(
                'fieldName' => 'id', // field name in the database
                'encoding' => 'UTF-8',
                'isStored' => true,
                'isIndexed' => true,
                'isTokenized' => true,
                'boost' => 1,
            ),
            'title' => array(
                'fieldName' => 'title',
                'encoding' => 'UTF-8',
                'isStored' => true,
                'isIndexed' => true,
                'isTokenized' => true,
                'boost' => 2,
            ),
            'text' => array(
                'fieldName' => 'text',
                'encoding' => 'UTF-8',
                'isStored' => true,
                'isIndexed' => true,
                'isTokenized' => true,
                'boost' => 1,
            ),
            'tags' => array(
                'fieldName' => 'tags',
                'encoding' => 'UTF-8',
                'isStored' => true,
                'isIndexed' => true,
                'isTokenized' => true,
                'boost' => 3,
            ),
        ),
    ),
);
