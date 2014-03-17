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
    'doctrine'  => array(
        'driver' => array(
            'mhruser_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths'  => array(
                    __DIR__ . '/../src/MHRUser/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'MHRUser\Entity' => 'mhruser_driver'
                )
            ),
        ),
    ),
);