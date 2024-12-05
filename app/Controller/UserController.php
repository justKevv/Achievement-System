<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Models\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
    }

    public function login($email, $user_password)
    {

        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_password = filter_var($user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->userModel->findByEmail($email);

        if ($user && strtoupper(hash('sha256', $user_password)) === $user['user_password']) {
            // Store user data in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['is_logged_in'] = true;

            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        } else {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }

    public function logout() {
        session_destroy();
        $response = new \Slim\Psr7\Response();
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
