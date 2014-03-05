<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/3/14
 * Time: 5:06 PM
 */

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User
{
    /**
     * @ORM $id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     *  @ORM\Column(type="string")
     */
    protected $fullName;

    // getters/setters
} 