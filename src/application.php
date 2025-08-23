<?php

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


// Define project root path
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

final class Application
{
    private function __construct() {}

    /**
     * Returns an absolute path by concatenating the project root with a given path
     */
    public static function path(string $path = ''): string
    {
        return PROJECT_ROOT . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

require_once __DIR__ . '/Infrastructure/Slim/slim.php';
