<?php
namespace StickyNotes;

use StickyNotes\Model\StickyNotesTable;

/**
 * Description of Module
 *
 * @author mhrilwan
 */
class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
    
    public function getConfig() {
        
        return include __DIR__ . '/config/module.config.php';

    }
    public function getServiceConfig() 
    {
        return array(
            'abstract_factories' => array(),
            'aliases' => array(),
            'factories' => array(
                //DB
                'StickyNotesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new StickyNotesTable($dbAdapter);
                    return $table;
                },
            ),
            'invokables' => array(),
            'services' => array(),
            'shared' => array(),
        );
    }
}

?>
