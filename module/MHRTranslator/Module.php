<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 8:51 PM
 */

namespace MHRTranslator;

use Zend\ServiceManager\Config;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
    //            __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getTranslatorConfig()
    {
        return array(
            'factories' => array(
                //'MHRTranslator\Translator\Loader\DoctrineLoader' => 'MHRTranslator\Service\DoctrineLoaderFactory'
              'MHRTranslator\Translator\Loader\DbTableLoader' => 'MHRTranslator\Service\DbTableLoaderFactory'
            ),
//            'aliases' => array(
//                'db' => 'Zend\Db\Adapter\Adapter',
//            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $this->configureTranslator($sm);
    }

    public function configureTranslator($sm)
    {
        $plugins = $sm->get('translator')->getPluginManager();

        $plugins->getServiceLocator($sm);


//        $plugins->setFactory('DbTable', function  (ServiceManager $serviceManager)
//
//        {
//var_dump($serviceManager);die();
//            $loader = new Translator\Loader\DbTableLoader($serviceManager->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//
//            return $loader;

//        });
        $config = new Config($this->getTranslatorConfig());
        $config->configureServiceManager($plugins);
//        echo '<pre>';
//        var_dump($plugins);
//        die('sad');

    }
} 