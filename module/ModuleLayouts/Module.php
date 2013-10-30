<?php
namespace ModuleLayouts;

/**
 * Description of Module
 * 
 * simply allows you to specify alternative layouts to use for each module.
 * 
 * USAGE:
 * In any module config or autoloaded config file simply specify the following:

array(
    'module_layouts' => array(
        'ModuleName' => 'layout/some-layout',
    ),
);
 *
 * @author mhrilwan
 */
class Module {
    public function onBootstrap($e) {
        $e->getApplication()->getEventmanager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e){
        
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
    }
}

?>
