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
use Doctrine\ORM\EntityManager;

class IndexController extends AbstractActionController
{
    /**
     * Entity manager instance
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Index action displays a list of all the users
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getEntityManager()->getRepository('Album\Entity\Album')->findAll()
            )
        );
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
} 