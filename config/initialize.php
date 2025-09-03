<?php

// Define project root path
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__, 1));
}

$autoloadFile = PROJECT_ROOT . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run this project.');
}

require_once $autoloadFile;

if (file_exists(PROJECT_ROOT . DIRECTORY_SEPARATOR . '.env')) {
    try {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(
            PROJECT_ROOT,
            '.env'
        );
        $dotenv->load();
    } catch (
        \Dotenv\Exception\InvalidEncodingException|
        \Dotenv\Exception\InvalidFileException|
        \Dotenv\Exception\InvalidPathException $e
    ) {
        if (getenv('APP_DEBUG') !== null && getenv('APP_DEBUG')) {
            echo sprintf(
                'Environment configuration error: %s in %s on line %d',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } else {
            echo 'Application configuration error. Please contact system administrator.';
        }
        exit(1);
    }
}

// Report all PHP errors
error_reporting(E_ALL);

// Display errors on screen
ini_set('display_errors', 1);
// Display startup errors
ini_set('display_startup_errors', 1);
// Don't limit the error output length
ini_set('log_errors_max_len', 0);
// Format errors to include HTML when appropriate
ini_set('html_errors', 1);
// Increase memory limit if needed for development
ini_set('memory_limit', '256M');