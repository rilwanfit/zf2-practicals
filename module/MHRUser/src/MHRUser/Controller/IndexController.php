<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:57 PM
 */

namespace MHRUser\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
} 