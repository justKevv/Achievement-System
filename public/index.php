<?php

require "../routes/route.php";
require "../database/database.php";
require "../app/View.php";

require "../app/Controller/UserController.php";

$db = new Database();
$router = new Router();
$userController = new UserController($db);

$router->get('/', function() {
    View::render('../resources/views/login.html');
});

$router->post('/', function () use ($userController) {
    $userController->login($_POST['username'], $_POST['password']);
});


$router->get('/home', function() {
    View::render('../resources/views/home.php');
});

$router->get('/submission', function() {
    View::render('../resources/views/submission.php');
});

$router->get('/rank', function() {
    View::render('../resources/views/rank.php');
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
