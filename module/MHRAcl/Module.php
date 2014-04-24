<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 4/24/14
 * Time: 11:09 AM
 */

namespace MHRAcl;


class Module {
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'mhracl_login_form' => function ($sm) {
                        $oForm = new Form\Login(null);
                        $oForm->setInputFilter(new Form\LoginFilter($sm));
                        return $oForm;
                    },
            ),
        );
    }
} 