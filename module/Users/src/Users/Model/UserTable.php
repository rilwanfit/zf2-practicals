<?php

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Description of UserTable
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class UserTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function saveUser(User $user) {
        $data = array(
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
        );

        $user_id = (int) $user->user_id;

        if ($user_id == 0) {
            $this->tableGateway->insert($data);
        } else {

            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('user_id' => $user_id));
            } else {
                throw new \Exception('User ID does not exist.');
            }
        }
    }

    public function getUser($user_id) {
        $user_id = (int) $user_id;
        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $user_id");
        }
        return $row;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getUserByEmail($userEmail) {
        $rowset = $this->tableGateway->select(array('email' => $userEmail));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $userEmail");
        }
        return $row;
    }

    public function deleteUser($user_id) {
        $user_id = (int) $user_id;
        $this->tableGateway->delete(array('user_id' => $user_id));
    }

}

?>
