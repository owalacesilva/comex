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
    define('PROJECT_ROOT', dirname(__DIR__, 1));
}

/**
 * Application class for managing file paths within the project
 *
 * This final class provides static methods to handle file paths relative to the project root
 * and source directories. It prevents instantiation and ensures consistent path handling.
 */
final class Application
{
    /**
     * Private constructor to prevent instantiation
     */
    private function __construct()
    {
    }

    /**
     * Get the absolute path from project root
     *
     * @param string $path Optional relative path to append to project root
     * @return string Absolute path with proper directory separators
     */
    public static function root(string $path = ''): string
    {
        if (empty($path)) {
            return PROJECT_ROOT;
        }

        return PROJECT_ROOT . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Get the absolute path from the src directory
     *
     * @param string $path Optional relative path to append to src directory
     * @return string Absolute path with proper directory separators
     */
    public static function src(string $path = ''): string
    {
        return self::root('src' . (empty($path) ? '' : DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR)));
    }

    /**
     * Retrieves the configuration file path based on the provided sub-path.
     *
     * @param string $path Optional sub-path to append to the configuration directory.
     * @return string The full path to the specified configuration file or directory.
     */
    public static function config(string $path = ''): string
    {
        return self::root('config' . (empty($path) ? '' : DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR)));
    }
}

require_once Application::src('Infrastructure/Slim/slim.php');;
