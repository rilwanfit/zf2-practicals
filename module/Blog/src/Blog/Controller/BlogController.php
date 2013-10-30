<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of BlogController
 *
 * @author mhrilwan < rilwanfit@gmail.com >
 */
class BlogController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
}

?>
