<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 9:05 PM
 */

namespace MHRTranslator\Service;


use MHRTranslator\Translator\Loader\DoctrineLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineLoaderFactory implements FactoryInterface
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
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get('Doctrine\ORM\EntityManager');

        return new DoctrineLoader($em);
    }

}