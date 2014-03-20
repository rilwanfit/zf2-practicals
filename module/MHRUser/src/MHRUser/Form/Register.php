<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/18/14
 * Time: 2:47 PM
 */

namespace MHRUser\Form;

use Zend\Form\Element\Captcha as Captcha;
use Zend\Captcha\Figlet;
use Zend\Form\Form;
use Zend\Form\Element;


class Register extends Form
{
    protected $captchaElement= null;

    /**
     * @var RegistrationOptionsInterface
     */
   // protected $registrationOptions;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {

        parent::__construct($name);

        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => 'Password Verify',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

//        $this->add(array(
//            'type' => 'Zend\Form\Element\Captcha',
//            'name' => 'captcha',
//            'options' => array(
//                'label' => 'Please verify you are human',
//                'captcha' => new Figlet(),
//            ),
//        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Submit')
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->add(array(
            'name' => 'userId',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));





        $this->remove('userId');
//        if (!$this->getRegistrationOptions()->getEnableUsername()) {
//            $this->remove('username');
//        }
//        if (!$this->getRegistrationOptions()->getEnableDisplayName()) {
//            $this->remove('display_name');
//        }
//        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha() && $this->captchaElement) {
//            $this->add($this->captchaElement, array('name'=>'captcha'));
//        }
        $this->get('submit')->setLabel('Register');
       // $this->getEventManager()->trigger('init', $this);
    }

    public function setCaptchaElement(Captcha $captchaElement)
    {
        $this->captchaElement= $captchaElement;
    }

    /**
     * Set Registration Options
     *
     * @param RegistrationOptionsInterface $registrationOptions
     * @return Register
     */
    public function setRegistrationOptions(RegistrationOptionsInterface $registrationOptions)
    {
        $this->registrationOptions = $registrationOptions;
        return $this;
    }

    /**
     * Get Registration Options
     *
     * @return RegistrationOptionsInterface
     */
    public function getRegistrationOptions()
    {
        return $this->registrationOptions;
    }
} 