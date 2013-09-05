<?php

namespace Aria;

class Mvc_Model_User extends Mvc_Model
{
    public $id;
    public $username;

    public function getAllUsers()
    {
        return $this->_db->query("select * from user");
    }

    public function getUserById($userId)
    {
        return $this->_db->query("select * from user where id=$userId");
    }

    public function getUserByName($username)
    {
        return $this->_db->query("select * from user where username='$username';");
    }

    public function checkCredentials($username, $password)
    {
        $result = $this->_db->query("select * from user where username='$username' and password='$password';");
        if (sizeof($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
