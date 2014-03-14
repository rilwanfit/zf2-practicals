<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:44 PM
 */

return array(
    // Doctrine Config
//    'doctrine' => array(
//        'driver'    => array(
//            'application_entities' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(__DIR__ . '/../src/Application/Entity')
//            )
//        )
//    ),
//    'orm_default' => array(
//        'drivers' => array(
//            'Application\Entity' => 'application_entities'
//        )
//    ),


    'doctrine'  => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'path'  => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '/Entity' => __NAMESPACE__ . '_driver'
                )
            ),
        ),
    ),

    'router' => array(
        'routes' => array(
            'mhr-user' => array(
                'type'      => 'segment',
                'options'   =>  array(
                    'route'     => '/mhr-user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
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