<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    protected function csvAction($filename, $resultset) 
    {
        $view = new ViewModel();
        $view->setTemplate('download/download-csv')
             ->setVariable('results', $resultset)
             ->setTerminal(true);
        
        if(!empty($columnHeaders)) {
            $view->setVariable('columnHeaders', $columnHeaders);
        }
        
        $output = $this->getServiceLocator()
                        ->get('viewrenderer')
                        ->render($view);
        
        $response = $this->getResponse();
        
        $headers = $response->getHeaders();
        
        $headers->addHeaderLine('Content-Type', 'text/csv')
                ->addHeaderLine('Content-Disposition', sprintf("attachement; filename=\"$s\"",$filename))
                ->addHeaderLine('Accept-Ranges','bytes')
                ->addHeaderLine('Content-Length',strln($output));
        
        $response->setContent($output);
        
        return $response;
    }
    
}
