<?php

namespace App\Services;

class AchievementService
{
    private $achievementModel;
    private $achievementFileModel;

    public function __construct($db)
    {
        $this->achievementModel = new \App\Models\Achievement($db);
        $this->achievementFileModel = new \App\Models\AchievementFile($db);
    }

    public function createAchievement(array $data, array $files)
    {
        try {
            $achievementData = [
                "achievement_title" => $data['title'],
                "achievement_description" => $data['description'],
                "achievement_category" => $data['category'],
                "achievement_date" => $data['date'],
                "achievement_organizer" => $data['organizer'],
                "user_id" => $data['user_id']
            ];

            $achievementId = $this->achievementModel->create($achievementData);

            if (!$achievementId) {
                throw new \Exception("Failed to create achievement");
            }

            $fileResults = $this->achievementFileModel->create(
                $achievementId,
                $files['activities'],
                $files['certificate']
            );

            if (!$fileResults) {
                throw new \Exception('Failed to save achievement files');
            }

            return $achievementId;
        } catch (\Exception $e) {
            error_log("Achievement service creation error: " . $e->getMessage());
            throw $e;
        }
    }
}
