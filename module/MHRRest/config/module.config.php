<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 2/27/14
 * Time: 5:30 PM
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'MHRRest\Controller\MHRIndex' => 'MHRRest\Controller\MHRIndexController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'mhr-index' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/mhr-index[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MHRIndex\Controller\MHRIndex',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mhr-index' => __DIR__ . '/../view',
        ),
    ),
);