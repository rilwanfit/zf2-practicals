<?php
namespace Users\Form;

use Zend\InputFilter\InputFilter;

/**
 * Description of LoginFitler
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class LoginFilter extends InputFilter {
    
    public function __construct() {
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));
        
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
        ));
    }
    
}

?>
