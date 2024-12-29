<?php

require_once "../vendor/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// library to store the database direct to the .env
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

try {
    $projectRoot = dirname(__DIR__);

    $dotenv = Dotenv::createImmutable($projectRoot); //final data can't change 
    $dotenv->load(); // to load the databases 

    require_once "../routes/app.php"; // call into the app.php

} catch (InvalidPathException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit();
}
