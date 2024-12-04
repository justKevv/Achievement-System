<?php

namespace App\Models;

use PDO;

class Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function sanitize($data)
    {
        return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function save($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->db->prepareAndExecute($sql, $data);
    }

    public function update($table, $data, $where)
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set WHERE $where";
        $this->db->prepareAndExecute($sql, $data);
    }

    public function delete($table, $where, $params)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $this->db->prepareAndExecute($sql, $params);
    }

    public function findById($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->prepareAndExecute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }
}
