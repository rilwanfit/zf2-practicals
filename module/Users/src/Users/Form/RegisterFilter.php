<?php

namespace Users\Form;

use Zend\InputFilter\InputFilter;

/**
 * Description of RegisterFilter
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class RegisterFilter extends InputFilter {

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

        //limit the size between 2- 140 chatactors and also strip HTML tags
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'confirm-password',
            'required' => true,
        ));
    }

}

?>
