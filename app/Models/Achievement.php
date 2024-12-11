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

}
