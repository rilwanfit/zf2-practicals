<?php
namespace CSV\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of IndexController
 *
 * @author mhrilwan
 */
class IndexController extends AbstractActionController {
     public function indexAction($filename, $resultset) 
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

?>
