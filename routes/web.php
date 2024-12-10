<?php

use App\Controller\DashboardController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\RoleMiddleware;
use Slim\App;
use App\View;
use App\ErrorHandler;

use App\Controller\ForgetPasswordController;
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
    })->add(new RedirectIfAuthenticated($app->getContainer()));
    
    $app->get('/logout', function ($request, $response, $args) use ($db) {
        $userController = new UserController($db);
        return $userController->logout();
    });


    $app->get('/dashboard[/{page}]', function ($request, $response, $args) use ($db) {
        $dashboardController = new DashboardController($db);
        return $dashboardController->index($request, $response, $args);
    })->add(new RoleMiddleware($app->getContainer(), $_SESSION['role_id'] ?? null))
        ->add(new AuthMiddleware($app->getContainer()));

    // Handle 404 Page
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        ob_start();
        ErrorHandler::handle404();
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response->withStatus(404);
    });
};
