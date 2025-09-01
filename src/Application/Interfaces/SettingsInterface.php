<?php

namespace Application\Interfaces;

/**
 * Interface defining methods for accessing application settings
 */
interface SettingsInterface
{
    public function get(string $key, mixed $default = null);
}