<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 9:03 PM
 */

namespace MHRTranslator\Translator\Loader;


use Doctrine\ORM\EntityManager;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;

class DoctrineLoader implements RemoteLoaderInterface
{
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Load translations from a remote source.
     *
     * @param  string $locale
     * @param  string $textDomain
     * @return \Zend\I18n\Translator\TextDomain|null
     */
    public function load($locale, $textDomain)
    {
        // TODO :: Use $this->em to query the database
    }
}