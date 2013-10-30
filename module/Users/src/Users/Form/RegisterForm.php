<?php
namespace Users\Form;

use Zend\Form\Form;
/**
 * Description of RegisterForm
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class RegisterForm extends Form {
    public function __construct($name = null) {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
    
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Full Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Email',
                //'multiple' => true, //if you want to allow for mutliple email addresses.
            ),
//            'filters' => array(
//                array( 'name' => 'StringTrim' ),
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'EmailAddress',
//                    'options' => array(
//                        'messages' => array(
//                            \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid',
//                        ),
//                    ),
//                ),
//            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Password'
            )
        ));
        $this->add(array(
            'name' => 'confirm-password',
            'attributes' => array(
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Confirm Password'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Register',
            ),
            'options' => array(
                'label' => 'Register',
            )
        ));
        
        
        //More Form Elements
        //URL
        $this->add(array(
           'name' => 'url',
            'attributes' => array(
                'type' => 'url',
            ),
            'options' => array(
                'label' => 'Url',
            ),
        ));
        
        //Date & Time
        $this->add(array(
            'name' => 'date',
            'attributes' => array(
                'type' => 'date',
                'min' => '2012-01-01',
                'max' => '2020-01-01',
            ),
            'options' => array(
                'label' => 'Date & Time',
            )
        ));
        
        //Telephone 
        $this->add(array(
            'name' => 'telephone',
            'attributes' => array(
                'type' => 'number',
            ),
            'options' => array(
                'label' => 'Phone Number',
            ),
        ));
        
        
    }
    
    
}

?>
