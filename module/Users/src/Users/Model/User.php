<?php

namespace Users\Model;

/**
 * Description of User
 *
 * @author mh rilwan <rilwanfit@gmail.com> <http://mhrilwan.com>
 */
class User {

    public $user_id;
    public $name;
    public $email;
    public $password;

    public function setPassword($clearPassword) {
        $this->password = md5($clearPassword);
    }

    public function exchangeArray($data) {
        $this->user_id = ( isset($data['user_id']) ) ? $data['user_id'] : null;
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->email = ( isset($data['email']) ) ? $data['email'] : null;

        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

?>
