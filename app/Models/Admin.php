<?php

namespace App\Models;

use PDO;

class Admin extends Model
{
    protected $db;
    protected $table = 'dbo.admin';
    protected $id = 'admin_id';

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function save($table, $data = []) {
        try {
            $query = "INSERT INTO {$this->table} (user_id, admin_name, admin_nip)
                     VALUES (:user_id, :admin_name, :admin_nip)";

            $params = [
                ':user_id' => $data['user_id'],
                ':admin_name' => $data['admin_name'],
                ':admin_nip' => $data['admin_nip']
            ];

            $result = $this->db->prepareAndExecute($query, $params);
            return $result !== false;
        } catch (\PDOException $e) {
            error_log("Error saving admin: " . $e->getMessage());
            return false;
        }
    }

    public function update($table, $data, $where) {
        try {
            $query = "UPDATE {$this->table}
                     SET admin_name = :admin_name,
                         admin_nip = :admin_nip,
                         user_id = :user_id
                     WHERE admin_id = :admin_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':admin_id', $where['admin_id']);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':admin_name', $data['admin_name']);
            $stmt->bindParam(':admin_nip', $data['admin_nip']);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error updating admin: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $where, $params) {
        try {
            $query = "DELETE FROM {$this->table} WHERE admin_id = :admin_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':admin_id', $where['admin_id']);

            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("Error deleting admin: " . $e->getMessage());
            return false;
        }
    }

    public function findById($table, $id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE admin_id = :admin_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':admin_id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error finding admin: " . $e->getMessage());
            return false;
        }
    }
}
