<?php

use App\Controller\AchievementController;
use App\Controller\DashboardController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\RoleMiddleware;
use Slim\App;
use App\View;
use App\ErrorHandler;

use App\Controller\ForgetPasswordController;
use App\Controller\ProfileController;
use App\Controller\UserController;

// return function right here are connect to the app.php $routes variabel 
return function (App $app, $db) {

    // Login Route
    $app->group('/', function ($web) use ($db) {
        $web->get('', function ($request, $response, $args) {
            View::render('../resources/views/login.html'); // connect to the view.php in app folder only use to render the view
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

    $app->group('/api/achievements', function ($api) use ($db) {
        $api->post('/approve/{id}', function ($request, $response, $args) use ($db) {
            $achievementController = new AchievementController($db);
            return $achievementController->approve($request, $response, $args);
        });
        $api->post('/reject/{id}', function ($request, $response, $args) use ($db) {
            $achievementController = new AchievementController($db);
            return $achievementController->reject($request, $response, $args);
        });
    })->add(new RoleMiddleware($app->getContainer(), 'A'))
      ->add(new AuthMiddleware($app->getContainer()));


    $app->group('/', function ($web) use ($db) {
        $web->get('dashboard[/{page}]', function ($request, $response, $args) use ($db) {
            $dashboardController = new DashboardController($db);
            return $dashboardController->index($request, $response, $args);
        })->add(new RoleMiddleware($web->getContainer(), $_SESSION['role_id'] ?? null));

        $web->get('profile', function ($request, $response, $args) use ($db) {
            $profileController = new ProfileController($db);
            return $profileController->index($request, $response);
        })->add(new RoleMiddleware($web->getContainer(), $_SESSION['role_id'] ?? null));

        $web->post('achievement/create', function ($request, $response) use ($db) {
            $achievementController = new AchievementController($db);
            return $achievementController->create($request, $response);
        })->add(new RoleMiddleware($web->getContainer(), 'S'));
    })->add(new AuthMiddleware($app->getContainer()));

    // User Routes
    $app->group('/api/users', function ($api) use ($db) {
        $api->post('/add', function ($request, $response) use ($db) {
            $userController = new UserController($db);
            return $userController->createUser($request, $response);
        });
        $api->get('/get/{id}', function ($request, $response, $args) use ($db) {
            $userController = new UserController($db);
            return $userController->getUser($request, $response, $args);
        });
        $api->put('/edit/{id}', function ($request, $response, $args) use ($db) {
            $userController = new UserController($db);
            return $userController->updateUser($request, $response, $args);
        });
        $api->delete('/delete/{id}', function ($request, $response, $args) use ($db) {
            $userController = new UserController($db);
            return $userController->deleteUser($request, $response, $args);
        });
    })->add(new AuthMiddleware($app->getContainer()));

    // Handle 404 Page
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        ob_start();
        ErrorHandler::handle404();
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response->withStatus(404);
    });
};
