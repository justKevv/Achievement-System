<?php

use Slim\Factory\AppFactory;
use Config\Database;

$app = AppFactory::create(); // to create the routing system 
$db = new Database(); //create and calling the database 

$app->addErrorMiddleware(true, true, true); // all the error will go to the middle ware 
// use to check the error and give the error output (output kelihatan jelas)

// $routes 
$routes = require __DIR__ . '/../routes/web.php';
$routes($app, $db);

// connect to the index.php and it will run the app.php and web.php
$app->run();
