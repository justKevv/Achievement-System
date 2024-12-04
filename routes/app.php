<?php

use Slim\Factory\AppFactory;
use Config\Database;

$app = AppFactory::create();
$db = new Database();

$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/../routes/web.php';
$routes($app, $db);

$app->run();
