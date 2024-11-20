<?php

require "../../routes/route.php";
require "../../database/database.php";
require "../../app/Controller/UserController.php";

$db = new Database();
$router = new Router();
$userController = new UserController($db);

$router->get('/', function() {
    include '../../resources/views/login.html';
});

$router->post('/', function () use ($userController) {
    $userController->login($_POST['username'], $_POST['password']);
});


$router->get('/home', function() {
    include '../../resources/views/home.php';
});

$router->get('/submission', function() {
    include '../../resources/views/submission.php';
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
