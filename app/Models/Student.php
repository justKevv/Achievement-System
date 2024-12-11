<?php

namespace App\Models;

use PDO;

class Student extends Model
{
    protected $db;
    protected $table = 'dbo.student';
    protected $id = 'student_id';

    public function __construct($db)
    {
        parent::__construct($db);
    }


    public function save($table, $data)
    {
        try {
            $query = "INSERT INTO dbo.student (
                user_id, student_nim, student_name, student_study_program,
                student_gender, student_class, student_date_of_birth,
                student_enrollment_date, student_address, student_phone_number
            ) VALUES (
                :user_id, :student_nim, :student_name, :student_study_program,
                :student_gender, :student_class, :student_date_of_birth,
                :student_enrollment_date, :student_address, :student_phone_number
            )";

            $params = [
                ':user_id' => $data['user_id'],
                ':student_nim' => $data['student_nim'],
                ':student_name' => $data['student_name'],
                ':student_study_program' => $data['student_study_program'],
                ':student_gender' => $data['student_gender'],
                ':student_class' => $data['student_class'],
                ':student_date_of_birth' => $data['student_date_of_birth'],
                ':student_enrollment_date' => $data['student_enrollment_date'],
                ':student_address' => $data['student_address'],
                ':student_phone_number' => $data['student_phone_number']
            ];

            $result = $this->db->prepareAndExecute($query, $params);
            return $result !== false;
        } catch (\PDOException $e) {
            error_log("Database error in Student save(): " . $e->getMessage());
            throw $e;
        }
    }

    public function update($table, $data, $where)
    {
        try {
            $query = "UPDATE {$this->table} SET
                user_id = :user_id,
                student_nim = :student_nim,
                student_name = :student_name,
                student_study_program = :student_study_program,
                student_gender = :student_gender,
                student_class = :student_class,
                student_date_of_birth = :student_date_of_birth,
                student_enrollment_date = :student_enrollment_date,
                student_address = :student_address,
                student_phone_number = :student_phone_number
                WHERE student_id = :student_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':student_id', $where['student_id']);
            $this->bindStudentParams($stmt, $data);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error updating student: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $where, $params)
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE student_id = :student_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':student_id', $where['student_id']);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error deleting student: " . $e->getMessage());
            return false;
        }
    }

    public function findByUserId($userId)
{
    try {
        $query = "SELECT s.*, u.user_email
                 FROM dbo.student s
                 INNER JOIN users u ON s.user_id = u.user_id
                 WHERE s.user_id = :user_id";

        $params = [':user_id' => $userId];

        $result = $this->db->prepareAndExecute($query, $params);

        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    } catch (\PDOException $e) {
        error_log("Error finding student by user_id: " . $e->getMessage());
        throw $e;
    }
}

    private function bindStudentParams($stmt, $data)
    {
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':student_nim', $data['student_nim']);
        $stmt->bindParam(':student_name', $data['student_name']);
        $stmt->bindParam(':student_study_program', $data['student_study_program']);
        $stmt->bindParam(':student_gender', $data['student_gender']);
        $stmt->bindParam(':student_class', $data['student_class']);
        $stmt->bindParam(':student_date_of_birth', $data['student_date_of_birth']);
        $stmt->bindParam(':student_enrollment_date', $data['student_enrollment_date']);
        $stmt->bindParam(':student_address', $data['student_address']);
        $stmt->bindParam(':student_phone_number', $data['student_phone_number']);
    }
}
