<?php

namespace App\Models;

use PDO;

class Achievement extends Model
{
    protected $db;
    protected $table = 'dbo.achievements';
    protected $id = 'achievement_id';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        try {
            $sql = "INSERT INTO {$this->table}
                    (achievement_title, achievement_description, achievement_category,
                     achievement_date, achievement_status, achievement_organizer, user_id)
                    OUTPUT INSERTED.achievement_id
                    VALUES
                    (:title, :description, :category, :date, 'Pending', :organizer, :user_id)";

            $params = [
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':category' => $data['category'],
                ':date' => $data['date'],
                ':organizer' => $data['organizer'],
                ':user_id' => $data['user_id']
            ];

            $stmt = $this->db->prepareAndExecute($sql, $params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['achievement_id'];
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getRecentAchievements($limit = 3)
    {
        $sql = "SELECT TOP $limit s.student_name, a.achievement_title, a.achievement_category, a.achievement_organizer, a.achievement_date
                FROM {$this->table} a
                JOIN dbo.student s ON a.user_id = s.user_id
                ORDER BY a.achievement_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAchievementStats()
    {
        $sql = "SELECT
            SUM(CASE WHEN achievement_category = 'International' THEN 1 ELSE 0 END) as intern,
            SUM(CASE WHEN achievement_category = 'National' THEN 1 ELSE 0 END) as 'national',
            SUM(CASE WHEN achievement_category = 'Regional' THEN 1 ELSE 0 END) as regional
            FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAchievements()
    {
        $sql = "SELECT s.student_name, a.achievement_title, a.achievement_category, a.achievement_date, a.achievement_status
                FROM {$this->table} a
                JOIN dbo.student s ON a.user_id = s.user_id
                ORDER BY a.achievement_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAchievementsByUserId($userId)
    {
        $sql = "SELECT a.achievement_title, a.achievement_category, a.achievement_organizer, a.achievement_date, a.achievement_status
                FROM {$this->table} a
                WHERE a.user_id = :user_id
                ORDER BY a.achievement_date DESC";
        $params = [':user_id' => $userId];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
