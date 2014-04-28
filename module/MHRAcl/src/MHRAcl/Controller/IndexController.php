<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/5/14
 * Time: 4:57 PM
 */

namespace MHRAcl\Controller;


use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use MHRAcl\Entity\Role;

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
    protected $manageRoleForm;

    /**
     * Index action displays a list of all the users
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $oForm = $this->getManageRoleForm();

        return new ViewModel(
            array(
                'form' => $oForm
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


    public function getManageRoleForm()
    {
        if (!$this->manageRoleForm) {
            $this->setRoleForm($this->getServiceLocator()->get('mhracl_managerole_form'));
        }
        return $this->manageRoleForm;
    }

    public function setRoleForm(Form $manageRoleForm)
    {
        $this->manageRoleForm = $manageRoleForm;
    }
}