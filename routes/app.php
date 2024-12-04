<?php

use Slim\Factory\AppFactory;
use Database\Database;

$app = AppFactory::create();
$db = new Database();

$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/../routes/web.php';
$routes($app, $db);

$app->run();
