<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:57 PM
 */

namespace MHRUser\Controller;


use DoctrineORMModule\Form\Annotation\AnnotationBuilder; //Doctrine Annotations to create a form
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use MHRUser\Entity\User;

class IndexController extends AbstractActionController
{
    /**
     * Entity manager instance
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * @var Form
     */
    protected $registerForm;

    /**
     * @var LoginForm
     */
    protected $loginForm;

    /**
     * Index action displays a list of all the users
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
//        if(!$this->_getUserIdentity()) {
//            return $this->redirect()->toRoute('mhr-user/default', array('controller'=>'index', 'action' => 'login'));
//        }
        return new ViewModel(
            array(
                'users' => $this->getEntityManager()->getRepository('MHRUser\Entity\User')->findAll()
            )
        );
    }

    public function addAction()
    {
        if(!$this->_getUserIdentity()) {
            return $this->redirect()->toRoute('mhr-user/default', array('controller'=>'index', 'action' => 'login'));
        }

        $oForm = $this->getRegisterForm();

        $entityManager = $this->getEntityManager();

        $oUser = new User();

        if($this->request->isPost()) {
            $oForm->setData($this->request->getPost());
            if($oForm->isValid()) {
                //$oUser->setFirstName($this->getRequest()->getPost('firstName'));
                //$oUser->setLastName($this->getRequest()->getPost('lastName'));

                $oUser->setUsername($this->getRequest()->getPost('username'));
                $oUser->setEmail($this->getRequest()->getPost('email'));
                $oUser->setDisplayName($this->getRequest()->getPost('display_name'));
                $oUser->setPassword($this->getRequest()->getPost('password'),'123456');

                $entityManager->persist($oUser);
                $entityManager->flush();
                //$newId = $oUser->getId();

                return $this->redirect()->toRoute('mhr-user');
            }

        }

        return new ViewModel(array(
            'form' => $oForm
        ));
    }


    public function editAction()
    {

        $oForm = $this->getRegisterForm();

        $entityManager = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);

        $oUser = $entityManager->find('\MHRUser\Entity\User', $id);

        if ($this->request->isPost()) {
            $oUser->setFirstName($this->getRequest()->getPost('firstName'));
            $oUser->setLastName($this->getRequest()->getPost('lastName'));

            $this->getEntityManager()->persist($oUser);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('mhr-user');
        }

//        $oForm->bind($oUser);

        return new ViewModel(array(
            'form' => $oForm,
            'id'   => $id,
        ));


        //return new ViewModel(array('user' => $user));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getEntityManager()->find('\MHRUser\Entity\User', $id);

        if ($this->request->isPost()) {
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('mhr-user');
        }

        return new ViewModel(array('user' => $user));
    }


    public function loginAction()
    {
        $oForm = $this->getLoginForm();
        $oForm->get('submit')->setValue('Login');
        $messages = null;

        $entityManager = $this->getEntityManager();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $oForm->setData($request->getPost());

            if ($oForm->isValid()) {

                $data = $oForm->getData();


                // Authenticate user
                $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
                $auth->getAdapter()->setIdentityValue($data['username']);
                $auth->getAdapter()->setCredentialValue($data['password']);
                $authResult = $auth->authenticate();

                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $auth->getStorage()->write($identity);
                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                    //- if ($data['rememberme']) $authService->getStorage()->session->getManager()->rememberMe($time); // no way to get the session
                    if ($data['rememberme']) {
                        $sessionManager = new \Zend\Session\SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                    return $this->redirect()->toRoute('mhr-user');
                }
                foreach ($authResult->getMessages() as $message) {
                    $messages .= "$message\n";
                }

                /*
                $identity = $authenticationResult->getIdentity();
                $authService->getStorage()->write($identity);

                $authenticationService = $this->serviceLocator()->get('Zend\Authentication\AuthenticationService');
                $loggedUser = $authenticationService->getIdentity();
                */
            }
        }
        return new ViewModel(array(
            'error' => 'Your authentication credentials are not valid',
            'form'	=> $oForm,
            'messages' => $messages,
        ));
    }

    public function logoutAction()
    {

        if($this->_getUserIdentity()) {
            $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
            $auth->clearIdentity();
            $sessionManager = new \Zend\Session\SessionManager();
            $sessionManager->forgetMe();
        }

        return $this->redirect()->toRoute('mhr-user/default', array('controller' => 'index', 'action' => 'login'));

    }

    protected function _getUserIdentity() {
        $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        return $auth->getIdentity();
    }


    /**
     * Returns an instance of the Doctrine entity manager loaded from the service locator
     *
     *  @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }


    public function getRegisterForm()
    {
        if (!$this->registerForm) {
            $this->setRegisterForm($this->getServiceLocator()->get('mhruser_register_form'));
        }
        return $this->registerForm;
    }

    public function setRegisterForm(Form $registerForm)
    {
        $this->registerForm = $registerForm;
    }

    public function getLoginForm()
    {
        if (!$this->loginForm) {
            $this->setLoginForm($this->getServiceLocator()->get('mhruser_login_form'));
        }
        return $this->loginForm;
    }

    public function setLoginForm(Form $loginForm)
    {
        $this->loginForm = $loginForm;
    }
}