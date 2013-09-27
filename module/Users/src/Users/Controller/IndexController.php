<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;

/**
 * Description of IndexController
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class IndexController extends AbstractActionController 
{

    public function indexAction() 
    {
        $view = new ViewModel();
        return $view;
    }
    
    public function registerAction() 
    {
        $view = new ViewModel();
        $view->setTemplate('users/index/new-user');
        return $view;
    }
    
    public function loginAction() 
    {
        $form = new LoginForm();
        $viewModel = new ViewModel(array(
            'form' => $form
        ));
        return $viewModel;
        
    }
    
}

?>
