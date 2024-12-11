<?php

namespace App\Controller;

use App\Models\Achievement;
use App\Models\Student;
use App\View;

class DashboardController extends Controller
{
    private $achievementModel;
    private $studentModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->achievementModel = new Achievement($this->db);
        $this->studentModel = new Student($this->db);
    }

    public function index($request, $response, $args)
    {
        error_log("Session data: " . print_r($_SESSION, true));
        error_log("User ID from session: " . ($_SESSION['user_id'] ?? 'not set'));

        $page = $args['page'] ?? 'home';
        $filePath = "../resources/views/pages/{$page}.php";
        $data = [];

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($_SESSION['role_id'] == 'A') {
            if ($page === 'home') {
                $data = [
                    'stats' => $this->achievementModel->getAchievementStats(),
                    'recent' => $this->achievementModel->getRecentAchievements(),
                ];
            } elseif ($page === 'user') {
                $users = $this->achievementModel->getAllUsers() ?? [];
                $data = [
                    'users' => $users,
                ];
            }
        } elseif ($_SESSION['role_id'] == 'S') {
            $mahasiswa = $this->studentModel->findByUserId($_SESSION['user_id']) ?? [];

            $data = [
                'student' => $mahasiswa,
            ];
        }

        if ($isAjax) {
            if (!file_exists($filePath)) {
                return $response->withStatus(404)
                    ->getBody()->write("Page not found");
            }

            extract($data);

            ob_start();
            require $filePath;
            $output = ob_get_clean();
            $response->getBody()->write($output);
            return $response;
        }

        extract($data);

        ob_start();
        View::render('../resources/views/dashboard.php', $data ?? []);
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response;
    }
}
