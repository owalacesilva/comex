<?php

namespace Infrastructure\Settings;

use Application\Interfaces\SettingsInterface;
use InvalidArgumentException;
use JsonException;

/**
 * JSON-based settings implementation that reads configuration from a JSON file.
 */
readonly class JsonSettings implements SettingsInterface
{
    private array $settings;

    /**
     * Initializes settings from a JSON file.
     *
     * @param string $jsonFilePath Path to the JSON configuration file
     * @throws InvalidArgumentException If file doesn't exist or can't be read
     * @throws JsonException If JSON parsing fails
     */
    public function __construct(string $jsonFilePath)
    {
        if (!file_exists($jsonFilePath)) {
            throw new InvalidArgumentException(sprintf('Settings file not found: %s', $jsonFilePath));
        }

        $jsonContent = file_get_contents($jsonFilePath);
        if ($jsonContent === false) {
            throw new InvalidArgumentException(sprintf('Failed to read settings file: %s', $jsonFilePath));
        }

        try {
            $settings = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
            $this->settings = $this->flattenArray($settings);
        } catch (JsonException $e) {
            throw new JsonException(
                sprintf('Invalid JSON in settings file %s: %s', $jsonFilePath, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieves a setting value by key using dot notation.
     *
     * @param string $key The setting key (dot notation supported for nested settings)
     * @param mixed $default Default value if setting is not found
     * @return mixed The setting value or default if not found
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Converts a nested array to a flat array with dot notation keys.
     *
     * @param array $array The array to flatten
     * @param string $prefix The current key prefix
     * @return array The flattened array
     */
    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value) && !empty($value) && !array_is_list($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }
}