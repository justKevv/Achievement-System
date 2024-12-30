<?php

namespace App\Models;

use PDO;

class Verification extends BaseModel
{
    protected $table = 'dbo.verification';
    protected $primaryKey = 'verification_id';

    public function create($achievementId, $adminId, $verifiedBy)
    {
        try {
            $sql = "INSERT INTO {$this->table}
                    (achievement_id, admin_id, verification_by, verification_at)
                    VALUES
                    (:achievement_id, :admin_id, :verification_by, GETDATE())";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':achievement_id', $achievementId, PDO::PARAM_INT);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            $stmt->bindParam(':verification_by', $verifiedBy);

            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Verification creation error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getVerificationByAchievementId($achievementId)
    {
        try {
            $sql = "SELECT v.verification_by, v.verification_at
                FROM {$this->table} v
                WHERE v.achievement_id = :achievement_id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':achievement_id', $achievementId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error getting verification: " . $e->getMessage());
            return false;
        }
    }
}
