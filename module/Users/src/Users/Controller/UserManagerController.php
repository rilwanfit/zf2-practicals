<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
/**
 * Description of UserManagerController
 *
 * @author mhrilwan
 */
class UserManagerController extends AbstractActionController {
    
    public function indexAction() {
        $userTable = $this->getServiceLocator()->get('UserTable');
        
        //Attach profiler
        $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')->setProfiler(new \QueryAnalyzer\Db\Adapter\Profiler\QueryAnalyzerProfiler());
        
        $viewModel = new ViewModel(array(
            'users' => $userTable->fetchAll(),
        ));
        return $viewModel;
    }
    
    public function editAction() {
        
        $userTable = $this->getServiceLocator()->get('UserTable');
        $user = $userTable->getUser($this->params()->fromRoute('id'));
        
        $form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user);
        
        $viewModel = new ViewModel(array(
            'form' => $form,
            'user_id' => $this->params()->fromRoute('id'),
        ));
        return $viewModel;
    }
    public function processAction() {
        //GEt user id from POST
        $post = $this->request->getPost();
        
        $userTable = $this->getServiceLocator()->get('UserTable');
        
        // Load User entity
        $user = $userTable->getUser($post->id);
        
        //Bind user entity to form
        $form = $this->getServiceLocator()->get('UserEditForm');
        
        $form->bind($user);
        $form->setData($post);
        
        //save user
        $userTable->saveUser($user);
        
    }
    public function deleteAction() {
        $this->getServiceLocator()->get('UserTable')->deleteUser($this->params()->fromRoute('id'));
    }
}

?>
