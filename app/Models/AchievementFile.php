<?php

namespace App\Models;

use PDO;

class AchievementFile extends BaseModel
{
    protected $table = 'dbo.achievement_files';
    protected $primaryKey = 'file_id';
    protected $fillable = [
        'achievement_id',
        'achievement_activities_documentation',
        'achievement_certifications',
    ];

    public function create($achievementId, $activities, $certificate)
    {
        try {
            $this->validateFileContent($activities);
            $this->validateFileContent($certificate);

            // Convert binary data to hex string for SQL Server
            $activitiesHex = '0x' . bin2hex($activities);
            $certificateHex = '0x' . bin2hex($certificate);

            $sql = "INSERT INTO {$this->table}
                   (achievement_id, achievement_activities_documentation, achievement_certifications, uploaded_at)
                   VALUES (
                       :achievement_id,
                       CONVERT(varbinary(max), {$activitiesHex}),
                       CONVERT(varbinary(max), {$certificateHex}),
                       GETDATE()
                   )";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':achievement_id', $achievementId, PDO::PARAM_INT);

            $result = $stmt->execute();
            return $result !== false;

        } catch (\Exception $e) {
            error_log("File creation error: " . $e->getMessage());
            throw $e;
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
