<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 9:05 PM
 */
namespace MHRTranslator\Service;

use MHRTranslator\Translator\Loader\DbTableLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class DbTableLoaderFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * $serviceLocator is the translator plugin manager, to get into the
     * root service locator we need the getServiceLocator() call
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        //$sm = $serviceLocator->getServiceLocator();

        $oDbAdapter = $serviceLocator->get('dbTableAdapter');

//        $aConfig = $serviceLocator->get('Config');
//        var_dump($aConfig);
//        die();

//        return new DbTableLoader();
        // Configure the translator
       //$config = $sm->get('db');
//
        echo '<pre>';
//
        var_dump( $oDbAdapter);
//
        die('loader factory');
//
//        $trConfig = isset($config['translator']) ? $config['translator'] : array();
//
//        if ( isset($trConfig['translation_db']) ) {
//            foreach($trConfig['translation_db'] as &$translation_db) {
//                if ( is_string($translation_db['db']) ) {
//                    $translation_db['db'] = $serviceLocator->get($translation_db['db']);
//                }
//            }
//        }
//        $translator = Translator::factory($trConfig);
//        return $translator;



        $sm = $serviceLocator->getServiceLocator();
//        $em = $sm->get('Doctrine\ORM\EntityManager');

        return new DbTableLoader($em);
    }

}