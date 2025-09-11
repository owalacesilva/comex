<?php

namespace Application\UseCases;

use Application\Repositories\SettingsRepositoryInterface;
use Domain\Entities\SettingEntity;
use Psr\Log\LoggerInterface;

/**
 * Use case responsible for retrieving all settings from the repository
 */
readonly class ListSettingsUseCase
{
    /**
     * Creates a new ListSettingsUseCase instance
     *
     * @param LoggerInterface $logger InterfaceAdapter to logger service
     * @param SettingsRepositoryInterface $settingsRepository Interface to settings repository
     */
    public function __construct(
        private LoggerInterface             $logger,
        private SettingsRepositoryInterface $settingsRepository
    )
    {
    }

    /**
     * Executes the use case to retrieve all settings
     *
     * @return SettingEntity[] Array containing all system settings
     */
    public function execute(): array
    {
        $this->logger->debug("List settings.");

        return $this->settingsRepository->getAll();
    }
}