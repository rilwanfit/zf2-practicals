<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/26/14
 * Time: 9:03 PM
 */

namespace MHRTranslator\Translator\Loader;


//use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;

class DbTableLoader implements RemoteLoaderInterface
{
    /**
     * Database adapter.
     *
     * @var DbAdapter
     */
    protected $dbAdapter;

//    function __construct(DbAdapter $dbAdapter)
//    {
//        $this->dbAdapter = $dbAdapter;
//    }


    /**
     * Load translations from a remote source.
     *
     * @param  string $locale
     * @param  string $textDomain
     * @return \Zend\I18n\Translator\TextDomain|null
     */
    public function load($locale, $textDomain)
    {

        die('loader');
        return $textDomain;
    }
}