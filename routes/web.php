<?php

use Slim\App;
use App\View;
use App\ErrorHandler;

use App\Controller\UserController;

return function (App $app, $db) {

    // Login Route
    $app->group('/', function ($web) use ($db) {
        $web->get('', function ($request, $response, $args) {
            View::render('../resources/views/login.html');
            return $response;
        });

        $web->post('', function ($request, $response, $args) use ($db) {
            $data = $request->getParsedBody();

            $userController = new UserController($db);
            return $userController->login(
                $data['email'] ?? '',  // Use email field name to match form
                $data['password'] ?? '' // Use password field name to match form
            );
        });

        $web->get('logout', function ($request, $response, $args) use ($db) {
            $userController = new UserController($db);
            return $userController->logout();
        });
    });



    $app->get('/dashboard[/{page}]', function ($request, $response, $args) {
        $page = $args['page'] ?? 'home';
        $filePath = "../resources/views/pages/{$page}.php";

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

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
        View::render('../resources/views/dashboard.php');
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response;
    });

    // Handle 404 Page
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        ob_start();
        ErrorHandler::handle404();
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response->withStatus(404);
    });
};
