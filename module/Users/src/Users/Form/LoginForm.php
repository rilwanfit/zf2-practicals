<?php
namespace Users\Form;

use Zend\Form\Form;

/**
 * Description of LoginForm
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class LoginForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'class' => 'input-unstyled',
                'id' => 'login',
                'autocomplete' => 'off',
                'placeholder' => 'Login',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'input-unstyled',
                'id' => 'pass',
                'autocomplete' => 'off',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'button glossy full-width huge'
            ),
        ));
    }
    
}

?>
