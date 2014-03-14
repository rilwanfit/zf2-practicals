<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/13/14
 * Time: 4:51 PM
 */

namespace MHRUser\Entity;

use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $fullName;

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($value)
    {
        return $this->fullName = $value;
    }

} 