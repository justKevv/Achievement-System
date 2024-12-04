<?php

use Slim\App;
use App\View;
use App\ErrorHandler;

use App\Controller\UserController;

return function (App $app, $db) {
    $app->get('/', function ($request, $response, $args) {
        View::render('../resources/views/login.html');
        return $response;
    });

    $app->post('/', function ($request, $response, $args) use ($db) {
        $data = $request->getParsedBody();

        $userController = new UserController($db);
        return $userController->login(
            $data['email'] ?? '',  // Use email field name to match form
            $data['password'] ?? '' // Use password field name to match form
        );
    });

    $app->get('/home', function ($request, $response, $args) {
        ob_start();
        View::render('../resources/views/home.php');
        $ouput = ob_get_clean();
        $response->getBody()->write($ouput);
        return $response;
    });

    $app->get('/submission', function ($request, $response, $args) {
        ob_start();
        View::render('../resources/views/submission.php');
        $ouput = ob_get_clean();
        $response->getBody()->write($ouput);
        return $response;
    });

    $app->get('/rank', function ($request, $response, $args) {
        ob_start();
        View::render('../resources/views/rank.php');
        $ouput = ob_get_clean();
        $response->getBody()->write($ouput);
        return $response;
    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        ob_start();
        ErrorHandler::handle404();
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response->withStatus(404);
    });
};
