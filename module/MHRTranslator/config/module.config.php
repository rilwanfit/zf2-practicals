<?php

return array(
    'translator' => array(
        'locale' => 'ta_SL', //en_US
        'remote_translation' => array(
            array(
                'type'           => 'MHRTranslator\Translator\Loader\DbTableLoader',
                'dbTableAdapter' => 'Zend\Db\Adapter\Adapter',
                'table_name'     => 'translation',
            ),
        ),
    ),
);
