<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'CSV\Controller\Index' => 'CSV\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'csv' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/csv',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'CSV\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                      
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'csv' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'download/download-csv' => __DIR__ . '/../view/csv/download/download-csv.phtml',
        )
    ),
);