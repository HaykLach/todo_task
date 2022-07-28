<?php

namespace Models;

use \Models\Database;


class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUser($login) : object | bool
    {
        $this->db->query("SELECT * FROM users WHERE username = :login");
        $this->db->bind(':login', $login);
        if ($this->db->execute()) {
            return $this->db->single();
        }
        return new \stdClass();
    }
}