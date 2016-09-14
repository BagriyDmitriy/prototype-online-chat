<?php

namespace App;

final class Db
{
    private $db;

    public function __construct($hostname, $username, $password, $database, $port = '3306')
    {
        $this->db = new \mysqli($hostname, $username, $password, $database, $port);

        if ($this->db->connect_error) {
            echo 'Error: Could not make a database db (' . $this->db->connect_errno . ') ' . $this->db->connect_error;
            exit();
        }

        $this->db->set_charset("utf8");
        $this->db->query("SET SQL_MODE = ''");
    }

    public function query($sql)
    {
        $query = $this->db->query($sql);

        if (!$this->db->errno) {
            if ($query instanceof \mysqli_result) {
                $data = array();

                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->num_rows = $query->num_rows;
                $result->row = isset($data[0]) ? $data[0] : array();
                $result->rows = $data;

                $query->close();

                return $result;
            } else {
                return true;
            }
        } else {
            echo 'Error: ' . $this->db->error  . '<br />Error No: ' . $this->db->errno . '<br />' . $sql;
        }
    }

    public function escape($value)
    {
        return $this->db->real_escape_string($value);
    }

    public function countAffected()
    {
        return $this->db->affected_rows;
    }

    public function getLastId()
    {
        return $this->db->insert_id;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}