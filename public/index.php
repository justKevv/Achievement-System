<?php

require_once "../vendor/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

try {
    $projectRoot = dirname(__DIR__);

    $dotenv = Dotenv::createImmutable($projectRoot);
    $dotenv->load();

    require_once "../routes/app.php";

} catch (InvalidPathException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit();
}
