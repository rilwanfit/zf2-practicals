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

        )
    ),
    'controllers' => array(
        'invokables' => array(
            'MHRAcl\Controller\Index'      => 'MHRAcl\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
//        'template_map' => array(
//            'mhr-acl/index/index' => __DIR__ . '/../view/mhr-acl/index/index.phtml'
//        ),
        'template_path_stack' => array(
            'mhr-acl' => __DIR__ . '/../view',
        ),
    ),
);