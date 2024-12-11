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

    public function getAllStudent()
    {
        try {
            $query = "SELECT s.student_nim, s.student_name, s.student_study_program, s.student_class, u.user_email FROM dbo.student s INNER JOIN dbo.users u ON s.user_id = u.user_id ORDER BY s.student_nim ASC;";
            $result = $this->db->query($query);

            if ($result) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }


            return null;
        } catch (\PDOException $e) {
            error_log("Error getting all student: " . $e->getMessage());
            throw $e;
        }
    }

    public function getRecentTop3Achievement($userId)
    {
        try {
            $query = "SELECT TOP 3
                    a.achievement_title,
                    a.achievement_category,
                    a.achievement_organizer,
                    a.achievement_date
                FROM dbo.achievements a
                WHERE a.user_id = :user_id
                ORDER BY a.achievement_date DESC";

            $params = [':user_id' => $userId];
            $result = $this->db->prepareAndExecute($query, $params);

            if ($result) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Error getting recent top 3 student achievement: " . $e->getMessage());
            throw $e;
        }
    }

    public function getAchievement($user_id)
    {
        try {
            $query = "SELECT * FROM dbo.achievment WHERE user_id = :user_id";
            $params = [':user_id' => $user_id];

            $result = $this->db->prepareAndExecute($query, $params);

            if ($result) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Error getting student achievment: " . $e->getMessage());
            throw $e;
        }
    }

    public function getTotalAchievement($user_id)
    {
        try {
            $query = "SELECT COUNT(achievement_id) as total FROM dbo.achievements WHERE user_id = :user_id";
            $params = [':user_id' => $user_id];

            $result = $this->db->prepareAndExecute($query, $params);

            if ($result) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Error getting sum student achievment: " . $e->getMessage());
            throw $e;
        }
    }

    public function getRank($limit)
    {
        try {
            $limit = (int)$limit;

            $query = "WITH RankedStudents AS (
                SELECT
                    s.student_name,
                    COUNT(a.achievement_id) as total_achievements,
                    ROW_NUMBER() OVER (ORDER BY COUNT(a.achievement_id) DESC) as rank
                FROM dbo.student s
                LEFT JOIN dbo.achievements a ON s.user_id = a.user_id
                GROUP BY s.student_name
            )
            SELECT TOP {$limit}
                rank,
                student_name,
                total_achievements
            FROM RankedStudents
            ORDER BY rank ASC";

            $result = $this->db->query($query);

            if ($result) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\PDOException $e) {
            error_log("Error getting rank list: " . $e->getMessage());
            throw $e;
        }
    }

    public function getCurrentRank($user_id)
    {
        try {
            $query = "WITH RankedStudents AS (
                SELECT
                    s.user_id,
                    s.student_name,
                    COUNT(a.achievement_id) as total_achievements,
                    ROW_NUMBER() OVER (ORDER BY COUNT(a.achievement_id) DESC) as rank
                FROM dbo.student s
                LEFT JOIN dbo.achievements a ON s.user_id = a.user_id
                GROUP BY s.user_id, s.student_name
            )
            SELECT rank, total_achievements
            FROM RankedStudents
            WHERE user_id = :user_id";

            $params = [':user_id' => $user_id];
            $result = $this->db->prepareAndExecute($query, $params);

            if ($result) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\PDOException $e) {
            error_log("Error getting current rank: " . $e->getMessage());
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
