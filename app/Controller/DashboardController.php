<?php


namespace App\Controller;

use App\Models\Achievement;
use App\Models\Student;
use App\Models\User;
use App\View;

class DashboardController extends Controller
{
    private $achievementModel;
    private $studentModel;
    private $userModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->achievementModel = new Achievement($this->db);
        $this->studentModel = new Student($this->db);
        $this->userModel = new User($this->db);
    }

    public function index($request, $response, $args)
    {
        error_log("Session data: " . print_r($_SESSION, true));
        error_log("User ID from session: " . ($_SESSION['user_id'] ?? 'not set'));

        $page = $args['page'] ?? 'home';
        $filePath = "../resources/views/pages/{$page}.php";
        $data = [];

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        switch ($_SESSION['role_id']) {
            case 'A':
                if ($page === 'home') {
                    $stats = $this->achievementModel->getAchievementStats();
                    $data = [
                        'stats' => $stats,
                        'adminRecent' => $this->achievementModel->getRecentAchievements(),
                        'rankAdmin' => $this->studentModel->getRank(6),
                    ];
                } elseif ($page === 'approval') {
                    $adminAchievements = $this->achievementModel->getAllAchievements() ?? [];
                    $data = [
                        'adminAchievements' => $adminAchievements
                    ];
                } elseif ($page === 'user') { // Ensure this case matches the page name
                    $userData = $this->userModel->getAllUsers() ?? [];
                    $data = [
                        'users' => $userData
                    ];
                }

                break;

            case 'S':
                if ($page === 'submission') {
                    $studentAchievements = $this->achievementModel->getAchievementsByUserId($_SESSION['user_id']) ?? [];
                    $data = [
                        'studentAchievements' => $studentAchievements
                    ];
                } elseif ($page === 'rank') {
                    $ranking = $this->studentModel->getRankAll() ?? [];
                    $data = [
                        'rankStudent' => $ranking
                    ];
                } else {
                    $mahasiswa = $this->studentModel->findByUserId($_SESSION['user_id']) ?? [];
                    $recentStudent = $this->studentModel->getRecentTop3Achievement($_SESSION['user_id']) ?? [];
                    $total = $this->studentModel->getTotalAchievement($_SESSION['user_id']) ?? [];
                    $currentRank = $this->studentModel->getCurrentRank($_SESSION['user_id']) ?? [];
                    $rank = $this->studentModel->getRank(3);
                    $studentStats = $this->achievementModel->getAchievementStats();

                    $data = [
                        'student' => $mahasiswa,
                        'recentStudent' => $recentStudent,
                        'total' => $total,
                        'currentRank' => $currentRank,
                        'ranking' => $rank,
                        'studentStats' => $studentStats
                    ];
                }
                break;

            case 'C':
                if ($page === 'home') {
                    $statsChairman = $this->achievementModel->getAchievementStats();
                    $chairmanRecent = $this->achievementModel->getRecentAchievements();
                    $rankChair = $this->studentModel->getRank(6);

                    $data = [
                        'statsChairman' => $statsChairman,
                        'chairmanRecent' => $chairmanRecent,
                        'rankChair' => $rankChair,
                    ];
                } else {
                    $chairmanStudents = $this->studentModel->getAllStudent() ?? [];
                    $data = [
                        'chairmanStudents' => $chairmanStudents
                    ];
                }
            default:
                $data = [];
                break;
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
