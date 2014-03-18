<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:57 PM
 */

namespace MHRUser\Controller;


use DoctrineORMModule\Form\Annotation\AnnotationBuilder; //Doctrine Annotations to create a form
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Zend\Form\Form;
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
     * @var Form
     */
    protected $registerForm;

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

        $oForm = $this->getRegisterForm();

        $entityManager = $this->getEntityManager();

        $oUser = new User();

        if($this->request->isPost()) {
            $oForm->setData($this->request->getPost());
            if($oForm->isValid()) {
                //$oUser->setFirstName($this->getRequest()->getPost('firstName'));
                //$oUser->setLastName($this->getRequest()->getPost('lastName'));

                $oUser->setUsername($this->getRequest()->getPost('username'));
                $oUser->setEmail($this->getRequest()->getPost('email'));
                $oUser->setDisplayName($this->getRequest()->getPost('display_name'));
                $oUser->setPassword($this->getRequest()->getPost('password'));

                $entityManager->persist($oUser);
                $entityManager->flush();
                //$newId = $oUser->getId();

                return $this->redirect()->toRoute('mhr-user');
            }

        }

//        $builder = new AnnotationBuilder( $entityManager );
//
//        $oForm = $builder->createForm( $oUser );
//
//        $oForm->setHydrator(new DoctrineHydrator($entityManager,'MHRUser\Entity\User'));
//        $oForm->bind($oUser);

        return new ViewModel(array(
            'form' => $oForm
        ));
    }


    public function editAction()
    {
        $entityManager = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);

        $oUser = $entityManager->find('\MHRUser\Entity\User', $id);

        if ($this->request->isPost()) {
            $oUser->setFirstName($this->getRequest()->getPost('firstName'));
            $oUser->setLastName($this->getRequest()->getPost('lastName'));

            $this->getEntityManager()->persist($oUser);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('mhr-user');
        }

        $builder = new AnnotationBuilder( $entityManager );

        $oForm = $builder->createForm( $oUser );

        $oForm->setHydrator(new DoctrineHydrator($entityManager,'MHRUser\Entity\User'));
        $oForm->bind($oUser);

        return new ViewModel(array(
            'form' => $oForm,
            'id'   => $id,
        ));


        //return new ViewModel(array('user' => $user));
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


    public function getRegisterForm()
    {
        if (!$this->registerForm) {
            $this->setRegisterForm($this->getServiceLocator()->get('mhruser_register_form'));
        }
        return $this->registerForm;
    }

    public function setRegisterForm(Form $registerForm)
    {
        $this->registerForm = $registerForm;
    }
}