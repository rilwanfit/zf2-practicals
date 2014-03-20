<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/20/14
 * Time: 2:09 PM
 */

namespace MHRUser\Controller;


use MHRUser\Entity\User;
use Zend\Form\Form;
use Zend\Mail\Message;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

class RegisterController extends AbstractActionController
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

    public function indexAction()
    {
        $oForm = $this->getRegisterForm();

        $entityManager = $this->getEntityManager();

        $oUser = new User();

        $oForm->setHydrator(new DoctrineHydrator($entityManager,'MHRUser\Entity\User'));

        if($this->request->isPost()) {
            $oForm->setData($this->request->getPost());
            if($oForm->isValid()) {
                //$oUser->setFirstName($this->getRequest()->getPost('firstName'));
                //$oUser->setLastName($this->getRequest()->getPost('lastName'));



                // prepare data
                $this->prepareData($oUser);

                $this->sendConfirmationEmail($oUser);
                $this->flashMessenger()->addMessage($oUser->getEmail());

                $entityManager->persist($oUser);
                $entityManager->flush();
                //$newId = $oUser->getId();

                return $this->redirect()->toRoute('mhr-user/default', array('controller'=>'register', 'action'=>'success'));
            }

        }

        return new ViewModel(array(
            'form' => $oForm
        ));
    }

    public function successAction()
    {
        $sEmail = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach($flashMessenger->getMessages() as $key => $value) {
                $sEmail .= $value;
            }
        }
        return new ViewModel(array('email' => $sEmail));
    }

    public function confirmEmailAction()
    {
        $token = $this->params()->fromRoute('id');
        $viewModel = new ViewModel(array('token' => $token));
        try {
            $entityManager = $this->getEntityManager();
            $user = $entityManager->getRepository('AuthDoctrine\Entity\User')->findOneBy(array('usrRegistrationToken' => $token)); //
            $user->setUsrActive(1);
            $user->setUsrEmailConfirmed(1);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        catch(\Exception $e) {
            $viewModel->setTemplate('auth-doctrine/registration/confirm-email-error.phtml');
        }
        return $viewModel;
    }


    public function prepareData($user)
    {

        $user->setUsername($this->getRequest()->getPost('username'));
        $user->setEmail($this->getRequest()->getPost('email'));
        $user->setDisplayName($this->getRequest()->getPost('display_name'));

        $user->setActive(0);
        $user->setPasswordSalt($this->generateDynamicSalt());
        $user->setPassword($this->encriptPassword(
            $this->getStaticSalt(),
            $user->getPassword(),
            $user->getPasswordSalt()
        ));
//        $user->setRoleId(2);
        $user->setLangId(1);
        $user->setRegistrationDate(new \DateTime());
        $user->setRegistrationToken(md5(uniqid(mt_rand(), true))); // $this->generateDynamicSalt();
        $user->setEmailConfirmed(0);

        return $user;
    }

    public function generateDynamicSalt()
    {
        $dynamicSalt = '';
        for ($i = 0; $i < 50; $i++) {
            $dynamicSalt .= chr(rand(33, 126));
        }
        return $dynamicSalt;
    }

    public function getStaticSalt()
    {
        $config = $this->getServiceLocator()->get('Config');
        $staticSalt = $config['static_salt'];
        return $staticSalt;
    }

    public function encriptPassword($staticSalt, $password, $dynamicSalt)
    {
        return $password = md5($staticSalt . $password . $dynamicSalt);
    }

    public function generatePassword($l = 8, $c = 0, $n = 0, $s = 0) {
        // get count of all required minimum special chars
        $count = $c + $n + $s;
        $out = '';
        // sanitize inputs; should be self-explanatory
        if(!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
            trigger_error('Argument(s) not an integer', E_USER_WARNING);
            return false;
        }
        elseif($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
            trigger_error('Argument(s) out of range', E_USER_WARNING);
            return false;
        }
        elseif($c > $l) {
            trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
            return false;
        }
        elseif($n > $l) {
            trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
            return false;
        }
        elseif($s > $l) {
            trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
            return false;
        }
        elseif($count > $l) {
            trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
            return false;
        }

        // all inputs clean, proceed to build password

        // change these strings if you want to include or exclude possible password characters
        $chars = "abcdefghijklmnopqrstuvwxyz";
        $caps = strtoupper($chars);
        $nums = "0123456789";
        $syms = "!@#$%^&*()-+?";

        // build the base password of all lower-case letters
        for($i = 0; $i < $l; $i++) {
            $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        // create arrays if special character(s) required
        if($count) {
        // split base password to array; create special chars array
            $tmp1 = str_split($out);
            $tmp2 = array();

        // add required special character(s) to second array
            for($i = 0; $i < $c; $i++) {
                array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
            }
            for($i = 0; $i < $n; $i++) {
                array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
            }
            for($i = 0; $i < $s; $i++) {
                array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
            }

            // hack off a chunk of the base password array that's as big as the special chars array
            $tmp1 = array_slice($tmp1, 0, $l - $count);
            // merge special character(s) array with base password array
            $tmp1 = array_merge($tmp1, $tmp2);
            // mix the characters up
            shuffle($tmp1);
            // convert to string for output
            $out = implode('', $tmp1);
        }

        return $out;
    }

    public function sendConfirmationEmail($user)
    {
        // $view = $this->getServiceLocator()->get('View');
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $this->getRequest()->getServer(); //Server vars
        $message->addTo($user->getEmail())
            ->addFrom('praktiki@coolcsn.com')
            ->setSubject('Please, confirm your registration!')
            ->setBody("Please, click the link to confirm your registration => " .
                $this->getRequest()->getServer('HTTP_ORIGIN') .
                $this->url()->fromRoute('mhr-user/default', array(
                    'controller' => 'register',
                    'action' => 'confirm-email',
                    'id' => $user->getRegistrationToken())));
        $transport->send($message);
    }

    public function sendPasswordByEmail($usr_email, $password)
    {
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $this->getRequest()->getServer(); //Server vars
        $message->addTo($usr_email)
            ->addFrom('praktiki@coolcsn.com')
            ->setSubject('Your password has been changed!')
            ->setBody("Your password at " .
                $this->getRequest()->getServer('HTTP_ORIGIN') .
                ' has been changed. Your new password is: ' .
                $password
            );
        $transport->send($message);
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