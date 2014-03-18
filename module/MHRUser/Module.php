<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:43 PM
 */

namespace MHRUser;



use MHRUser\Model\User;
use MHRUser\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
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
//                'MHRUser\Model\UserTable' => function($sm) {
//                        $tableGateway = $sm->get('UserTableGateway');
//                        $table = new UserTable($tableGateway);
//                        return $table;
//                    },
//                'UserTableGateway' => function ($sm) {
//                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                        $resultSetPrototype = new ResultSet();
//                        $resultSetPrototype->setArrayObjectPrototype(new User());
//                        return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
//                    },

//                  'mhruser_module_options' => function ($sm) {
//                          $config = $sm->get('Config');
//                          return new Options\ModuleOptions(isset($config['mhruser']) ? $config['mhruser'] : array());
//                  },

                  'mhruser_register_form' => function ($sm) {
//                        $options = $sm->get('mhruser_module_options');
                        $form = new Form\Register(null);
                        //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
                        $form->setInputFilter(new Form\RegisterFilter(
                            array(
                                'name'      => 'DoctrineModule\Validator\NoObjectExists',
                                'options' => array(
                                    'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('MHRUser\Entity\User'),
                                    'fields'            => 'email'
                                ),
                            ),
                            array(
                                'name'      => 'DoctrineModule\Validator\NoObjectExists',
                                'options' => array(
                                    'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('MHRUser\Entity\User'),
                                    'fields'            => 'email'
                                ),
                            )
                        ));
                        return $form;
                  },

            ),
        );
    }


} 