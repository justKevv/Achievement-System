<?php

namespace App\Controller;

use App\Models\Achievement;
use App\View;

class DashboardController extends Controller
{
    private $achievementModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->achievementModel = new Achievement($this->db);
    }

    public function index($request, $response, $args)
    {
        $page = $args['page'] ?? 'home';
        $filePath = "../resources/views/pages/{$page}.php";
        $data = [];

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

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

        if ($isAjax) {
            if (!file_exists($filePath)) {
                return $response->withStatus(404)
                    ->getBody()->write("Page not found");
            }
            ob_start();
            require $filePath;
            $output = ob_get_clean();
            $response->getBody()->write($output);
            return $response;
        }

        ob_start();
        View::render('../resources/views/dashboard.php', $data ?? []);
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response;
    }
}
