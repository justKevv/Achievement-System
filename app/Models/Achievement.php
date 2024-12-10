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

    public function getTopUsers($limit = 6)
    {
        $sql = "SELECT TOP $limit u.username, COUNT(a.{$this->id}) as points
                FROM dbo.users u
                LEFT JOIN {$this->table} a ON u.user_id = a.user_id
                GROUP BY u.username
                ORDER BY points DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $sql = "SELECT
    *
FROM
    dbo.admin -- Get all the users name, email, and user role display name
SELECT
    u.user_id,
    CASE
        WHEN r.role_id = 'S' THEN s.student_name
        WHEN r.role_id = 'A' THEN l.admin_name
    END as name,
    u.user_email,
    r.role_name
FROM
    dbo.users u
    JOIN dbo.roles r ON u.role_id = r.role_id
    LEFT JOIN dbo.student s ON u.user_id = s.user_id
    LEFT JOIN dbo.admin l ON u.user_id = l.user_id;";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
