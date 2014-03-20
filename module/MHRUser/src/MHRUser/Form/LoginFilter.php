<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/20/14
 * Time: 12:28 PM
 */

namespace MHRUser\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct($sm)
    {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                array(
                    'name'	=> 'DoctrineModule\Validator\ObjectExists',
                    'options' => array(
                        'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('MHRUser\Entity\User'),
                        'fields' => 'username'
                    ),

                ),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 12,
                    ),
                ),
            ),
        ));
    }
}