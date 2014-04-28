<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 4/24/14
 * Time: 11:09 AM
 */

namespace MHRAcl;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

use MHRAcl\Utility\Acl;

class Module
{

    private $app;

    private $serviceManager;

    public function onBootstrap(MvcEvent $e)
    {

        $this->app = $e->getApplication();
        $this->serviceManager = $this->app->getServiceManager();

        $em = $e->getApplication()->getEventManager();
        $oModuleRouteListerner = new ModuleRouteListener();
        $oModuleRouteListerner->attach($em);

        $em->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'beforeDispatch',
        ), 100);
    }

    public function beforeDispatch(MvcEvent $e)
    {
        $response = $e->getResponse();

        $whiteList = array(
            'MHRUser\Controller\Index-index',
            'MHRUser\Controller\Index-logout'
        );

        $controller = $e->getRouteMatch()->getParam('controller');
        $action = $e->getRouteMatch()->getParam('action');

        $requestedResourse = $controller . "-" . $action;

        $session = new Container('User');

       // if ($session->offsetExists('email')) {
            if ($requestedResourse == 'MHRUser\Controller\Index-index' || in_array($requestedResourse, $whiteList)) {
                $url = '/';
                $response->setHeaders($response->getHeaders()
                    ->addHeaderLine('Location', $url));
                $response->setStatusCode(302);
            } else {
                $serviceManager = $e->getApplication()->getServiceManager();
                $userRole = $session->offsetGet('roleName');


                // check user logged into system
                $auth = $this->serviceManager->get('doctrine.authenticationservice.orm_default');
                if($auth->getIdentity()) {
                    $session = new Container('User');
//                    $session->offsetSet('email', $data['email']);
//                    $session->offsetSet('userId', $userDetails[0]['user_id']);
//                    $session->offsetSet('roleId', $userDetails[0]['role_id']);
//                    $session->offsetSet('roleName', $userDetails[0]['role_name']);
                } else {
                    $userRole = Acl::DEFAULT_ROLE;
                }

                $acl = $serviceManager->get('Acl');
                $acl->initAcl();

                var_dump("Role :: ".$userRole . " Controller :: " . $controller . " Action :: " . $action);

                $status = $acl->isAccessAllowed($userRole, $controller, $action);
                if (! $status) {
                    die('Permission denied');
                }
            }
//        } else {
//
//            if ($requestedResourse != 'MHRUser\Controller\Index-index' && ! in_array($requestedResourse, $whiteList)) {
//                $url = '/login';
//                $response->setHeaders($response->getHeaders()
//                    ->addHeaderLine('Location', $url));
//                $response->setStatusCode(302);
//            }
//            $response->sendHeaders();
//        }
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Acl' => function ($serviceManager)
                    {
                        return new Acl();
                    },
            ),
        );
    }
} 