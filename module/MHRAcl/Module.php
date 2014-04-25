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

    public function onBootstrap(MvcEvent $e)
    {

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

                $acl = $serviceManager->get('Acl');
                $acl->initAcl();

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