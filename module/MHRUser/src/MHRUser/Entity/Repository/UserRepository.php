<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/20/14
 * Time: 12:15 PM
 */

namespace MHRUser\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository Table Data Gateway
 *
 * Class UserRepository
 * @package MHRUser\Entity\Repository
 */

class UserRepository extends EntityRepository
{
    public function getRolesArray($number = 30)
    {
        // $dql = "SELECT b, e, r, p FROM \GraceDrops\Entity\User b JOIN b.engineer e ".
        // "JOIN b.reporter r JOIN b.products p ORDER BY b.created DESC";
        // $query = $this->getEntityManager()->createQuery($dql);
        // $query->setMaxResults($number);
        // return $query->getArrayResult();
        return array();
    }
} 