<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
//use Users\Form\LoginFilter;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

use Zend\Json\Json;

/**
 * Description of LoginController
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class LoginController extends AbstractActionController {

    public function indexAction() {
        
        //Set Different Layout
        $layout = $this->layout();
        $layout->setTemplate('layout/layout2');
        
        $form = new LoginForm();
            $viewModel = new ViewModel(array(
                'form' => $form
            ));
        return $viewModel;
    }
    
     public function processAction() {
         
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array('controller'=>'login','action'=>'index'));
        }
        $post = $this->request->getPost();
        
        
        //Following code moved to module service manager.
//        $form = new LoginForm();
//        $inputFilter = new LoginFilter();
//        $form->setInputFilter($inputFilter);
        
        //Now Get LoginForm from service manager.
        $form = $this->getServiceLocator()->get('LoginForm');
        
        $form->setData($post);

        if(!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));
            $model->setTemplate('users/login');
            return $model;
        }
        //validate credentials
        $this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('email'))
                                             ->setCredential($this->request->getPost('password'));
               

        $result = $this->getAuthService()->authenticate();
        
        if($result->isValid()) {
            $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
            return $this->redirect()->toRoute(NULL, array('controller' => 'login','action'=>'confirm'));
        }
        
        return $this->redirect()->toRoute(NULL, array('controller' => 'index', 'action' => 'confirm'));
    }
    
    public function ajaxProcessAction() {
         
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array('controller'=>'login','action'=>'index'));
        }
        $post = $this->request->getPost();
        
        
        //Following code moved to module service manager.
//        $form = new LoginForm();
//        $inputFilter = new LoginFilter();
//        $form->setInputFilter($inputFilter);
        
        //Now Get LoginForm from service manager.
        $form = $this->getServiceLocator()->get('LoginForm');
        
        $form->setData($post);

        if(!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));
            $model->setTemplate('users/login');
            return $model;
        }
        //validate credentials
        $this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('email'))
                                             ->setCredential($this->request->getPost('password'));
               

        $result = $this->getAuthService()->authenticate();
        
        if($result->isValid()) {
            $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
            return $this->redirect()->toRoute(NULL, array('controller' => 'login','action'=>'confirm'));
        }
        
        return $this->redirect()->toRoute(NULL, array('controller' => 'index', 'action' => 'confirm'));
    }
    
    public function confirmAction() {
        $user_email = $this->getAuthService()->getStorage()->read();
        $viewModel = new ViewModel(array('user_email'=>$user_email));
        return $viewModel;
    }
    
    public function getAuthService() {
        
        if( ! $this->authservice ) {
            //Following code moved to module service manager.
//            $sm = $this->getServiceLocator();
//            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', 'MD5(?)');
//            $authService = new AuthenticationService();
//            $authService->setAdapter($dbTableAuthAdapter);
            
            //Now Get AuthService from service manager.
             $authService = $this->getServiceLocator()->get('AuthService');
            
            $this->authservice = $authService;
        }
        return $this->authservice;
    }
    
}

?>
