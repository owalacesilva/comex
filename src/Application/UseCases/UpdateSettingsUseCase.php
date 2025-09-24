<?php

namespace Application\UseCases;

use Application\Exceptions\DomainException;
use Application\Repositories\SettingsRepositoryInterface;
use Domain\Entities\SettingEntity;
use Psr\Log\LoggerInterface;

/**
 * Use case responsible for updating a setting in the repository
 */
readonly class UpdateSettingsUseCase
{
    /**
     * Creates a new UpdateSettingsUseCase instance
     *
     * @param LoggerInterface $logger Interface to logger service
     * @param SettingsRepositoryInterface $settingsRepository Interface to settings repository
     */
    public function __construct(
        private LoggerInterface             $logger,
        private SettingsRepositoryInterface $settingsRepository
    )
    {
    }

    /**
     * Executes the use case to update a setting
     *
     * @param SettingEntity[] $settings The settings to update
     * @return SettingEntity[] The updated setting entity
     */
    public function execute(array $settings): array
    {
        $this->logger->debug("Update settings.");

        // Save the updated settings
        $this->settingsRepository->update($settings);

        $this->logger->info("Settings updated successfully");

        return $settings;
    }
}
