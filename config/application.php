<?php
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
