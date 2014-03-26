<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 8:51 PM
 */

namespace MHRTranslator;

use Zend\ServiceManager\Config;

class Module
{
    public function getTranslatorConfig()
    {
        return array(
            'factories' => array(
                //'MHRTranslator\Translator\Loader\DoctrineLoader' => 'MHRTranslator\Service\DoctrineLoaderFactory'
                'MHRTranslator\Translator\Loader\DbTableLoader' => 'MHRTranslator\Service\DbTableLoaderFactory'
            )
        );
    }

    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $this->configureTranslator($sm);
    }

    public function configureTranslator($sm)
    {
        $plugins = $sm->get('translator')->getPluginManager();
        $plugins->getServiceLocator($sm);

        $config = new Config($this->getTranslatorConfig());
        $config->configureServiceManager($plugins);
    }
} 