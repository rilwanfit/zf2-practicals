<?php

namespace Acl\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

use Acl\Service\Acl as Acl;
use Acl\Model\Resource as AclResource;
use Acl\Model\Role as AclRole;
use Acl\Model\Rule as AclRule;


/**
 * Description of AclListener
 *
 * @author mhrilwan < rilwanfit@gmail.com >
 */
class AclListener implements ListenerAggregateInterface {

    protected $_listeners = array();

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events) {
        $this->_listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'initAcl'), 100);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events) {
        foreach ($this->_listeners as $index => $listener) {
            if($events->detach($listener)) {
                unset($this->_listeners[$index]);
            }
        }
    }
    
    public function initAcl(MvcEvent $e ) {
        $app = $e->getApplication();
        
        $sm = $app->getServiceManager();
        
        $acl = $sm->get('acl_acl');
        
        //Get Params 'Controller', 'Action', and 'Privilege' from rout match.
        $matches = $e->getRouteMatch();
        
        //Resource based on request params.
        $resource = new AclResource();
        $resource->setController($matches->getParam('controller'));
        $resource->setAction($matches->getParam('action','index'));
        
        //404 responss if resource does not exist.
        if(!$acl->hasResource($resource, true)) {
            $e->getResponse()->setStatusCode(404); return;
        }
        
        //Get config for Acl
        $config = $sm->get('config');
        $configAcl = $config['Acl'];
        
        //Role
        $auth = $sm->get('acl_auth_service');
        
        $role = new AclRole();
        $role->setName($auth->hasIdentity() ? $auth->getIdentity()->$configAcl['field_role'] : $configAcl['default_role']);
        
        //Query Acl
        $result = $acl->isAllowed($role, $resource, $e->getRequest()->getMethod());
        
        //403 unauthorized 
        if($result === false){
            //create view model
            $viewModel = new \Zend\View\Model\ViewModel();
            $viewModel->setTemplate('error/403');
            $viewModel->setVariable('reason', $acl::ERROR_UNATHORIZED);
            
            //Add model as child and set 403 status code.
            $e->getViewModel()->addChild($model);
            $e->getResponse()->setStatusCode(403);
            
            //stop propagation.
            $e->stopPropagation();
            return;
                    
        }
    }
}

?>
