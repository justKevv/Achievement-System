<?php

namespace App\Models;

use PDO;

class Chairman extends Model
{
    protected $db;
    protected $table = 'dbo.chairman';
    protected $id = 'chairman_id';

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function save($table, $data = []) {
        try {
            if (empty($data['user_id']) || empty($data['chairman_name']) || empty($data['chairman_nip'])) {
                error_log('Missing required chairman data');
                return false;
            }
            $query = "INSERT INTO {$this->table} (user_id, chairman_name, chairman_nip)
                     VALUES (:user_id, :chairman_name, :chairman_nip)";

            $params = [
                ':user_id' => $data['user_id'],
                ':chairman_name' => $data['chairman_name'],
                ':chairman_nip' => $data['chairman_nip']
            ];

            $result = $this->db->prepareAndExecute($query, $params);
            return $result !== false;
        } catch (\PDOException $e) {
            error_log("Error saving chairman: " . $e->getMessage());
            return false;
        }
    }

    public function update($table, $data, $where) {
        try {
            $query = "UPDATE {$this->table}
                     SET chairman_name = :chairman_name,
                         chairman_nip = :chairman_nip,
                         user_id = :user_id
                     WHERE chairman_id = :chairman_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':chairman_id', $where['chairman_id']);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':chairman_name', $data['chairman_name']);
            $stmt->bindParam(':chairman_nip', $data['chairman_nip']);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error updating chairman: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $where, $params) {
        try {
            $query = "DELETE FROM {$this->table} WHERE chairman_id = :chair";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':chairman_id', $where['chairman_id']);

            return $stmt->execute($params);

        } catch (\PDOException $e) {
            error_log("Error deleting chairman: " . $e->getMessage());
            return false;
        }
    }

}
