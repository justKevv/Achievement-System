<?php

namespace App\Models;

use PDO;

class Achievement extends BaseModel
{
    protected $table = "dbo.achievements";
    protected $primaryKey = "achievement_id";
    protected $fillable = [
        "achievement_title",
        "achievement_description",
        "achievement_category",
        "achievement_date",
        "achievement_status",
        "achievement_organizer",
        "user_id",
    ];

    public function create(array $data)
    {
        try {
            $validData = $this->validateData($data);
            $sql = "INSERT INTO {$this->table}
                                (" . implode(", ", array_keys($validData)) . ", achievement_status)
                                OUTPUT INSERTED.achievement_id
                                VALUES
                                (" . implode(", ", array_map(fn($field) => ":$field", array_keys($validData))) . ", 'Pending')";
            $stmt = $this->db->prepareAndExecute($sql, $this->buildQueryParams($validData));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["achievement_id"];
        } catch (\Exception $e) {
            error_log("Achievement creation error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getRecentAchievements($limit = 3)
    {
        $sql = "SELECT TOP {$limit} s.student_name, a.achievement_title, a.achievement_category,
                           a.achievement_organizer, a.achievement_date
                    FROM {$this->table} a
                    JOIN dbo.student s ON a.user_id = s.user_id
                    WHERE a.achievement_status = :status
                    ORDER BY a.achievement_date DESC";

        $params = [":status" => "Approved"];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAchievementStats()
    {
        $sql = "SELECT
            SUM(CASE WHEN achievement_category = 'International' THEN 1 ELSE 0 END) as intern,
            SUM(CASE WHEN achievement_category = 'National' THEN 1 ELSE 0 END) as 'national',
            SUM(CASE WHEN achievement_category = 'Regional' THEN 1 ELSE 0 END) as regional
            FROM {$this->table}
            WHERE achievement_status = 'Approved'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function getAllAchievements()
    {
        $sql = "SELECT a.*, s.student_name, v.verification_by, v.verification_at,
        af.achievement_activities_documentation,
        af.achievement_certifications
        FROM {$this->table} a
        JOIN dbo.student s ON a.user_id = s.user_id
        LEFT JOIN dbo.verification v ON a.achievement_id = v.achievement_id
        LEFT JOIN dbo.achievement_files af ON a.achievement_id = af.achievement_id";

        $achievements = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($achievements as &$achievement) {
            if (!empty($achievement['achievement_certifications'])) {
                // Encode binary data to Base64 for frontend usage
                $achievement['certificate_file'] = base64_encode($achievement['achievement_certifications']);
            } else {
                $achievement['certificate_file'] = '';
            }

            if (!empty($achievement['achievement_activities_documentation'])) {
                $achievement['documentation_file'] = base64_encode($achievement['achievement_activities_documentation']);
            } else {
                $achievement['documentation_file'] = '';
            }
        }

        return $achievements;
    }

    public function getAchievementsByUserId($userId)
    {
        $sql = "SELECT a.*, s.student_name, v.verification_by, v.verification_at,
            af.achievement_activities_documentation,
            af.achievement_certifications
            FROM {$this->table} a
            JOIN dbo.student s ON a.user_id = s.user_id
            LEFT JOIN dbo.verification v ON a.achievement_id = v.achievement_id
            LEFT JOIN dbo.achievement_files af ON a.achievement_id = af.achievement_id
            WHERE a.user_id = :user_id
            ORDER BY a.achievement_date DESC";

        $params = [":user_id" => $userId];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        $achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($achievements as &$achievement) {
            if (!empty($achievement['achievement_certifications'])) {
                $achievement['certificate_file'] = base64_encode($achievement['achievement_certifications']);
            } else {
                $achievement['certificate_file'] = '';
            }

            if (!empty($achievement['achievement_activities_documentation'])) {
                $achievement['documentation_file'] = base64_encode($achievement['achievement_activities_documentation']);
            } else {
                $achievement['documentation_file'] = '';
            }
        }

        return $achievements;
    }

    public function getAchievementsProfile($userId)
    {
        $sql = "SELECT a.achievement_id, a.achievement_title, a.achievement_category, a.achievement_organizer, a.achievement_date, a.achievement_status
                FROM {$this->table} a
                WHERE a.user_id = :user_id AND a.achievement_status = 'Approved'
                ORDER BY a.achievement_date DESC";
        $params = [":user_id" => $userId];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingAchievements()
    {
        $sql = "SELECT achievement_title
                FROM dbo.achievements
                WHERE achievement_status = 'Pending'";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($achievementId, array $data)
    {
        try {
            $sql = "UPDATE {$this->table}
                SET achievement_status = :status
                WHERE achievement_id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':status', $data['achievement_status']);
            $stmt->bindParam(':id', $achievementId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Achievement update error: " . $e->getMessage());
            throw $e;
        }
    }
}
