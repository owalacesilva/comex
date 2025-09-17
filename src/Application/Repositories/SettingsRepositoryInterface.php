<?php

namespace Application\Repositories;

use Domain\Entities\SettingEntity;

/**
 * Interface defining the contract for accessing system settings
 */
interface SettingsRepositoryInterface
{
    /**
     * Retrieves all settings from the repository
     *
     * @return SettingEntity[] Array containing all system settings
     */
    public function getAll(): array;

    /**
     * Update an settings list
     *
     * @param SettingEntity[] $settings The settings to update
     * @return void
     */
    public function update(array $settings): void;
}