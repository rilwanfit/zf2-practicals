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
use MHRUser\Entity\User;

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
                'users' => $this->getEntityManager()->getRepository('MHRUser\Entity\User')->findAll()
            )
        );
    }

    public function addAction()
    {
        if($this->request->isPost()) {
            $oUser = new User();

            $oUser->setFirstName($this->getRequest()->getPost('first_name'));

            $this->getEntityManager()->persist($oUser);
            $this->getEntityManager()->flush();
            $newId = $oUser->getId();

            return $this->redirect()->toRoute('mhr-user');

        }
        return new ViewModel();
    }


    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getEntityManager()->find('\MHRUser\Entity\User', $id);

        if ($this->request->isPost()) {
            $user->setFirstName($this->getRequest()->getPost('first_name'));

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('mhr-user');
        }

        return new ViewModel(array('user' => $user));
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