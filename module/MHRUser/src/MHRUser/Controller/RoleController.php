<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:57 PM
 */

namespace MHRUser\Controller;


use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use MHRUser\Entity\Role;

class RoleController extends AbstractActionController
{
    /**
     * Entity manager instance
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * @var Form
     */
    protected $roleForm;

    /**
     * Index action displays a list of all the users
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'roles' => $this->getEntityManager()->getRepository('MHRUser\Entity\Role')->findAll()
            )
        );
    }

    public function addAction()
    {

        $oForm = $this->getRoleForm();

        $entityManager = $this->getEntityManager();

        $oRole = new Role();

        if($this->request->isPost()) {

            $oForm->setData($this->request->getPost());

            if($oForm->isValid()) {

                $oRole->setFirstName($this->getRequest()->getPost('name'));

                $entityManager->persist($oRole);
                $entityManager->flush();

                return $this->redirect()->toRoute('mhr-role');
            }

        }

        return new ViewModel(array(
            'form' => $oForm
        ));
    }


    public function editAction()
    {

        $oForm = $this->getRoleForm();

        $entityManager = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);

        $oRole = $entityManager->find('\MHRUser\Entity\Role', $id);

        if ($this->request->isPost()) {

            $oRole->setRoleName($this->getRequest()->getPost('name'));

            $this->getEntityManager()->persist($oRole);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('mhr-role');
        }

        $oForm->bind($oRole);

        return new ViewModel(array(
            'form' => $oForm,
            'id'   => $id,
        ));

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


    public function getRoleForm()
    {
        if (!$this->roleForm) {
            $this->setRoleForm($this->getServiceLocator()->get('mhruser_role_form'));
        }
        return $this->roleForm;
    }

    public function setRoleForm(Form $roleForm)
    {
        $this->roleForm = $roleForm;
    }
}