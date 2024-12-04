<?php

namespace App\Controller;

require_once __DIR__ . "/Controller.php";

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
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/home')->withStatus(302);
        } else {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }
}
