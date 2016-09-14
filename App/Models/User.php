<?php

namespace App\Models;

class User extends Model
{
    public function getUser($username, $password)
    {
        $query = $this->db->query("SELECT * FROM user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))))");

        return $query;
    }

    public function getMessages($last_id)
    {
        $query = $this->db->query("SELECT m.id, m.message, mf.id AS file_id, mf.name_file, u.username FROM message m LEFT JOIN message_file AS mf ON (m.id = mf.message_id) LEFT JOIN user u ON (m.user_id = u.user_id) WHERE m.id > '" . $this->db->escape((int)$last_id) . "' ORDER BY m.id ASC");

        return $query->rows;
    }

    public function getFile($id)
    {
        $query = $this->db->query("SELECT * FROM message_file WHERE id = '" . $this->db->escape((int)$id) . "'");

        return $query->row;
    }

    public function getLastMessages($limit = 10)
    {
        $query = $this->db->query("SELECT * FROM (SELECT m.id, m.message, mf.id AS file_id, mf.name_file, u.username FROM message m LEFT JOIN message_file AS mf ON (m.id = mf.message_id) LEFT JOIN user u ON (m.user_id = u.user_id) ORDER BY m.id DESC LIMIT " . (int)$limit . ") AS m2 ORDER BY m2.id");

        return $query->rows;
    }

    public function findUser($username)
    {
        $query = $this->db->query("SELECT * FROM user WHERE username = '" . $this->db->escape($username) . "'");

        return $query;
    }

    public function saveMessage($message_content)
    {
        $this->db->query("INSERT INTO message SET user_id = '" . $this->db->escape($_SESSION['user_id']) . "', message = '" . $this->db->escape($message_content['message']) . "'");

        $message_id = $this->db->getLastId();

        if($message_content['txt_file']){
            $this->db->query("INSERT INTO message_file SET txt_file = '" . $this->db->escape($message_content['txt_file']) . "', name_file = '" . $this->db->escape($message_content['name_file']) . "', message_id = '" . $this->db->escape($message_id) . "', user_id = '" . $this->db->escape($_SESSION['user_id']) . "'");
        }

        return $message_id;
    }

    public function register($username, $password, $email, $homepage)
    {
        $this->db->query("INSERT INTO user SET username = '" . $this->db->escape($username) . "', homepage = '" . $this->db->escape($homepage) . "', email = '" . $this->db->escape($email) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "'");

        return $this->db->getLastId();
    }
}