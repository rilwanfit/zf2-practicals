<?php
return array(


    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            ))),



    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
            'Users\Controller\Register' => 'Users\Controller\RegisterController',
            'Users\Controller\Login' => 'Users\Controller\LoginController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'users' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/users',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Users\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
//            'user-manager' => array(
//                'type' => 'Segment',
//                'options' => array(
//                    'route' => '/user-manager[/:action[:/id]]',
//                    'constraints' => array(
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id'     => '[a-zA-Z0-9_-]*'
//                    ),
//                    'defaults' => array(
//                        'controller' => 'Users\MHRRest\UserManager',
//                        'action'    => 'index',
//                    ),
//                ),
//            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
    ),
);
