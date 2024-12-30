<?php

namespace App\Controller;

use App\Models\Achievement;
use App\Models\Student;
use App\View;

class ProfileController extends Controller
{
    private $studentModel;
    private $achievementModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->studentModel = new Student($db);
        $this->achievementModel = new Achievement($db);
    }

    public function index($request, $response)
    {
        try {
            // Get student profile data
            $studentProfile = $this->studentModel->findByUserId($_SESSION['user_id']);

            // Get student achievements
            $achievements = $this->achievementModel->getAchievementsProfile($_SESSION['user_id']);

            $data = [
                'studentProfile' => $studentProfile,
                'achievements' => $achievements
            ];

            ob_start();
            View::render('../resources/views/pages/profile.php', $data);
            $output = ob_get_clean();
            $response->getBody()->write($output);
            return $response;

        } catch (\Exception $e) {
            error_log("Error in ProfileController: " . $e->getMessage());
            return $response->withStatus(500);
        }
    }
}
