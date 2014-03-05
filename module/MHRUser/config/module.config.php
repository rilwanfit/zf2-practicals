<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:44 PM
 */

return array(
    'router' => array(
        'routes' => array(
            'mhr-user' => array(
                'type'      => 'literal',
                'options'   =>  array(
                    'route'     => '/mhr-user',
                    'defaults'  =>  array(
                        'controller' => 'MHRUser\Controller\Index',
                        'action'     => 'index'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'MHRUser\Controller\Index' => 'MHRUser\Controller\IndexController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mhr-user' => __DIR__ . '/../view',
        ),
    ),
);