<?php
namespace Acl;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceManager;

use Acl\Service\Acl;
use Acl\Listener\AclListener;
use Acl\Model\RulesDao;
use Acl\Model\RulesMapper;
use Acl\Model\Resource as AclResource;
use Acl\Model\Rule as AclRule;
use Acl\Model\Role as AclRole;
/**
 * Description of Module
 *
 * @author mhrilwan < rilwanfit@gmail.com >
 */
class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface, ServiceProviderInterface {
    
    public function onBootstrap(EventInterface $e) {
        $sm = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        
        $aclListerner = $sm->get('acl_acl_listener');
        $aclListerner->attach($eventManager);
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() 
    {
        return array(
            'abstract_factories' => array(),
            'aliases' => array(),
            'factories' => array(
                'acl_acl' => function($sm) {
                    $acl = new Acl($sm->get('acl_rules_dao'));
                    return $acl;
                },
                'acl_auth_service' => function($sm) {
                    $config = $sm->get('config');
                    $authorizeClass = $config['Acl']['authorize_provider'];
                    return new $authorizeClass;
                },
                'acl_rules_dao' => function($sm) {
                    $rulesMapper = $sm->get('acl_rules_mapper');
                    return new RulesDao($rulesMapper);
                },
                'acl_rules_mapper' => function($sm) {
                    $config = $sm->get('config');
                    return new RulesMapper($config['Acl']['data']);
                }
                
            ),
            'invokables' => array(
                'acl_acl_listener' => 'Acl\Listener\AclListener'
            ),
            'services' => array(),
            'shared' => array(),
        );
    }
}

?>
