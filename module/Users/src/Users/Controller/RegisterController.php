<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
//use Users\Form\RegisterFilter;
use Users\Model\User;

/**
 * Description of RegisterController
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class RegisterController extends AbstractActionController {

    public function indexAction() {
        
        
        $lang = $this->getEvent()->getRouteMatch()->getParam('lang', 'en');
        
        if(strtolower($lang) != 'en' && strtolower($lang) != 'tm' ) $lang = 'en';
        
        $translator = $this->getServiceLocator()->get('translator');
        $translator->addTranslationFile("phpArray", './module/Users/language/lang.array.'.$lang .'.php');
        
        $this->getServiceLocator()->get('ViewHelperManager')->get('translate')->setTranslator($translator);
        
        $form = new RegisterForm();
        $viewModel = new ViewModel(array(
            'form' => $form
        ));
        return $viewModel;
    }
    
    public function processAction() 
    {
        if(!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL,
                        array(
                            'controller' => 'register',
                            'action' => 'index',
                             ) 
                    );
        }
        
        $post = $this->request->getPost();
        
        //Following code moved to module service manager.
//        $form = new RegisterForm();
//        $inputFilter = new RegisterFilter();
//        $form->setInputFilter($inputFilter);
 
        //Now Get LoginForm from service manager.
        $form = $this->getServiceLocator()->get('RegisterForm');
        
        $form->setData($post);
        
        if(!$form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form'  => $form,
            ));
            $model->setTemplate('users/register/index');
            return $model;
        }
        
        //create user
        $this->createUser($form->getData());
        
        return $this->redirect()->toRoute(NULL, 
                array(
                    'controller' => 'register', 
                    'action' => 'confirm'
                    )
                );
    }
    
    public function confirmAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    protected function createUser( array $data ) {
        
        //Following code moved to module service manager.
//        $sm = $this->getServiceLocator();
//        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet(); 
//        $resultSetPrototype->setArrayObjectPrototype(new \Users\Model\User);
//        $tableGateway = new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);
        
        $user = new User();
        $user->exchangeArray($data);
        
        //moved to service manager
//        $userTable = new \Users\Model\UserTable($tableGateway);
        
        //Get UserTable from service manager.
        $userTable = $this->getServiceLocator()->get('UserTable');
        
        $userTable->saveUser($user);
        return true;
    }
}

?>
