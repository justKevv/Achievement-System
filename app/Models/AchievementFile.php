<?php

namespace App\Models;

use PDO;

class AchievementFile extends Model
{
    protected $db;
    protected $table = 'dbo.achievement_files';
    protected $id = 'file_id';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($achievementId, $activities, $certificate)
    {
        try {
            // Convert file contents to base64 to avoid encoding issues
            $activitiesContent = base64_encode($activities);
            $certificateContent = base64_encode($certificate);

            $sql = "INSERT INTO {$this->table}
                (achievement_id, achievement_activities_documentation, achievement_certifications, uploaded_at)
                VALUES (
                    :achievement_id,
                    CAST(:activities AS VARBINARY(MAX)),
                    CAST(:certificate AS VARBINARY(MAX)),
                    GETDATE()
                )";

            $params = [
                ':achievement_id' => $achievementId,
                ':activities' => $activitiesContent,
                ':certificate' => $certificateContent
            ];

            $stmt = $this->db->prepareAndExecute($sql, $params);
            return true;
        } catch (\Exception $e) {
            error_log("File creation error: " . $e->getMessage());
            return false;
        }
    }

    private function validateFileContent($content)
    {
        if (empty($content)) {
            throw new \Exception("File content is empty");
        }
        if (strlen($content) > 5 * 1024 * 1024) { // 5MB limit
            throw new \Exception("File size exceeds 5MB limit");
        }
        return true;
    }
}
