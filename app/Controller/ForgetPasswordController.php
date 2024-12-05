<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    private $userModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
    }

    public function forgot($email, $new_password, $confirm_password)
    {
        $new_password = filter_var($new_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->userModel->findByEmail($email);

        if ($user) {
            if ($new_password === $confirm_password) {
                $this->userModel->setUserPassword($new_password);
                $response = new \Slim\Psr7\Response();
                return $response->withHeader('Location', '/')->withStatus(code: 302);
            } else {
                $response = new \Slim\Psr7\Response();
                return $response->withHeader('Location', '/')->withStatus(code: 404);
            }
        } else {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/')->withStatus(code: 404);
        }
    }
}
