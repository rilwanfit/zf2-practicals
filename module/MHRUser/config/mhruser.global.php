<?php
$settings = array();

return array(
    'mhruser' => $settings,
    'service_manager' => array(
        'aliases' => array(
            'mhruser_zend_db_adapter' => (isset($settings['zend_db_adapter'])) ? $settings['zend_db_adapter']: 'Zend\Db\Adapter\Adapter',
        ),
    ),
);