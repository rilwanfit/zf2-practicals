<?php
namespace QueryAnalyzer;

use QueryAnalyzer\Listener\QueryAnalyzerListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
/**
 * Description of Module
 *
 * @author mhrilwan
 */
class Module implements ConfigProviderInterface {
    
    public function onBootstrap( MvcEvent $e ) {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        
        if($serviceManager->has('Zend\Db\Adapter\Adapter')) {
            $profiler = $serviceManager->get('Zend\Db\Adapter\Adapter')->getProfiler();
            $config = $serviceManager->get('config');
            
            if(isset($profiler) && $profiler instanceof \QueryAnalyzer\Db\Adapter\Profiler\QueryAnalyzerProfiler){
                $listener = new QueryAnalyzerListener(
                    $serviceManager->get('ViewRenderer'),
                    $profiler,
                    $config['queryanalyzer']
                );

                foreach($config['queryanalyzer']['loggers'] as $logger){
                    $listener->addLogger($serviceManager->get($logger));
                }

                $application->getEventManager()->getSharedManager()->attach('Zend\Mvc\Application', $listener, null);
            }
            
        }
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/queryanalyzer.config.php';
    }
}

?>
