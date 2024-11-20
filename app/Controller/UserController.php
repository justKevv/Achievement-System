<?php

require "../../app/Models/User.php";

class UserController
{
    private $db;
    private $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function login($username, $user_password)
    {

        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_password = filter_var($user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->userModel->findByUsername($username);
        if ($user && $user['user_password'] === $user_password)  {
            header('Location: /home');
            return;
        } else {
            echo "<script>alert('Login failed');</script>";
        }
        header('Location: /');
    }
}
