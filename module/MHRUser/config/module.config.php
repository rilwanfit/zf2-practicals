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
//            'mhr-user' => array(
//                'type'      => 'segment',
//                'options'   =>  array(
//                    'route'     => '/mhr-[:controller][/:action][/:id]',
//                    'constraints' => array(
//                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id' => '[0-9]+',
//                    ),
//                    'defaults'  =>  array(
//                        '__NAMESPACE__' => 'MHRUser\Controller',
//                        'controller' => 'Index',
//                        'action'     => 'index'
//                    )
//                ),
//            )
            'mhr-user' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/mhr-user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MHRUser\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '[-:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'MHRUser\Controller\Index'      => 'MHRUser\Controller\IndexController',
            'MHRUser\Controller\Register'   => 'MHRUser\Controller\RegisterController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mhr-user' => __DIR__ . '/../view',
        ),
    ),
    // Doctrine Config
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
        'authentication' => array(
            'orm_default' => array(
                //should be the key you use to get doctrine's entity manager out of zf2's service locator
                'objectManager' => 'Doctrine\ORM\EntityManager',
                //fully qualified name of your user class
                'identityClass' => 'MHRUser\Entity\User',
                //the identity property of your class
                'identityProperty' => 'username',
                //the password property of your class
                'credentialProperty' => 'password',
                //a callable function to hash the password with
                //'credentialCallable' => 'MHRUser\Entity\User::hashPassword'
            ),
        ),
    ),
);