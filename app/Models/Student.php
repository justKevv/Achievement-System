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

    public function updateStudent($userId, $data)
    {
        try {
            $query = "UPDATE dbo.student SET
            student_nim = :student_nim,
            student_name = :student_name,
            student_study_program = :student_study_program,
            student_gender = :student_gender,
            student_class = :student_class,
            student_date_of_birth = :student_date_of_birth,
            student_enrollment_date = :student_enrollment_date,
            student_address = :student_address,
            student_phone_number = :student_phone_number
            WHERE user_id = :user_id";

            $params = [
                ':user_id' => $userId,
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

            return $this->db->prepareAndExecute($query, $params);
        } catch (\PDOException $e) {
            error_log("Error updating student: " . $e->getMessage());
            throw $e;
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

    public function deleteStudent($userId)
    {
        try {
            $query = "DELETE FROM dbo.student WHERE user_id = :user_id";
            $params = [':user_id' => $userId];
            return $this->db->prepareAndExecute($query, $params);
        } catch (\PDOException $e) {
            error_log("Error in deleteStudent: " . $e->getMessage());
            throw $e;
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
                WHERE a.user_id = :user_id AND a.achievement_status = 'Approved'
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
            $query = "WITH AchievementPoints AS (
                        SELECT
                            a.user_id,
                            s.student_name,
                            a.achievement_category,
                            CASE
                                WHEN a.achievement_category = 'Regional' THEN 2
                                WHEN a.achievement_category = 'National' THEN 5
                                WHEN a.achievement_category = 'International' THEN 15
                                ELSE 0
                            END as points
                        FROM dbo.achievements a
                        JOIN dbo.student s ON a.user_id = s.user_id
                        WHERE a.achievement_status = 'Approved'
                        AND a.user_id = :user_id
                    )
                    SELECT
                        student_name,
                        SUM(points) as total_points,
                        SUM(CASE WHEN achievement_category = 'Regional' THEN points ELSE 0 END) as regional_points,
                        SUM(CASE WHEN achievement_category = 'National' THEN points ELSE 0 END) as national_points,
                        SUM(CASE WHEN achievement_category = 'International' THEN points ELSE 0 END) as international_points
                    FROM AchievementPoints
                    GROUP BY user_id, student_name;";
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

    public function getAllTotalPoints()
    {
        try {
            $query = "WITH AchievementPoints AS (
                    SELECT
                        a.user_id,
                        s.student_name,
                        a.achievement_category,
                        CASE
                            WHEN a.achievement_category = 'Regional' THEN 2
                            WHEN a.achievement_category = 'National' THEN 5
                            WHEN a.achievement_category = 'International' THEN 15
                            ELSE 0
                        END as points
                    FROM dbo.achievements a
                    JOIN dbo.student s ON a.user_id = s.user_id
                    WHERE a.achievement_status = 'Approved'
                )
                SELECT
                    student_name,
                    SUM(points) as total_points,
                    SUM(CASE WHEN achievement_category = 'Regional' THEN points ELSE 0 END) as regional_points,
                    SUM(CASE WHEN achievement_category = 'National' THEN points ELSE 0 END) as national_points,
                    SUM(CASE WHEN achievement_category = 'International' THEN points ELSE 0 END) as international_points
                FROM AchievementPoints
                GROUP BY user_id, student_name
                ORDER BY total_points DESC";

            $result = $this->db->query($query);

            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                error_log("Query result: " . print_r($data, true)); // Debug log
                return $data;
            }

            return [];
        } catch (\PDOException $e) {
            error_log("Error getting sum student achievements: " . $e->getMessage());
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
                    ROW_NUMBER() OVER (
                        ORDER BY
                            COUNT(a.achievement_id) DESC
                    ) as rank
                FROM
                    dbo.student s
                    LEFT JOIN dbo.achievements a ON s.user_id = a.user_id
                WHERE a.achievement_status = 'Approved'
                GROUP BY
                    s.student_name
            )
            SELECT
            TOP {$limit} rank, student_name, total_achievements
            FROM
                RankedStudents
            ORDER BY
                rank ASC";

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
                WHERE a.achievement_status = 'Approved'
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

    public function getRankAll()
    {
        try {
            $query = "WITH RankedStudents AS (
            SELECT
                s.student_name,
                s.student_nim,
                s.student_study_program,
                COUNT(a.achievement_id) as total_achievements,
                ROW_NUMBER() OVER (ORDER BY COUNT(a.achievement_id) DESC) as rank
            FROM dbo.student s
            LEFT JOIN dbo.achievements a ON s.user_id = a.user_id
            WHERE a.achievement_status = 'Approved'
            GROUP BY s.student_name, s.student_nim, s.student_study_program
            HAVING COUNT(a.achievement_id) > 0
        )
        SELECT
            rank,
            student_name,
            student_nim,
            student_study_program,
            total_achievements
        FROM RankedStudents
        ORDER BY rank ASC";

            $result = $this->db->query($query);

            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                error_log("Ranking data in model: " . print_r($data, true)); // Add this line
                return $data;
            }
            return null;
        } catch (\PDOException $e) {
            error_log("Error getting rank list: " . $e->getMessage());
            throw $e;
        }
    }
}
