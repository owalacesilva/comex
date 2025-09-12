<?php

namespace InterfaceAdapter;

use Application\Enumerations\HttpStatusCode;
use Application\Exceptions\DomainException;
use Application\Helpers\Result;
use Application\Repositories\SettingsRepositoryInterface;
use Application\UseCases\ListSettingsUseCase;
use Psr\Log\LoggerInterface;
use Exception;

/**
 * Class responsible for adapting the interface between the HTTP layer and the use case layer
 * for listing settings functionality
 */
class ListSettingsInterfaceAdapter
{
    private ListSettingsUseCase $useCase;

    /**
     * Creates a new ListSettingsInterfaceAdapter instance
     *
     * @param LoggerInterface $logger InterfaceAdapter to logger service
     * @param SettingsRepositoryInterface $settingsRepository Interface to settings repository
     */
    public function __construct(
        private readonly LoggerInterface             $logger,
        private readonly SettingsRepositoryInterface $settingsRepository
    )
    {
        $this->useCase = new ListSettingsUseCase(
            $this->logger,
            $this->settingsRepository,
        );
    }

    /**
     * Executes the list settings use case and handles any exceptions
     *
     * @return Result The result object containing either the settings list or error information
     */
    public function execute(): Result
    {
        $this->logger->info("List settings.");

        try {
            $settings = $this->useCase->execute();

            return Result::ok(
                array_map(fn($setting) => [
                    'id' => $setting->getId() ?? 0, // or whatever default makes sense
                    'key' => $setting->getKey(),
                    'value' => $setting->getValue(),
                    'description' => $setting->getDescription(),
                ], $settings)
            );
        } catch (DomainException $e) {
            $this->logger->error("Failed to list settings.", [$e->getMessage()]);

            return Result::fail(
                $e->getMessage(),
                "CD002",
                HttpStatusCode::UNPROCESSABLE_ENTITY
            );
        } catch (Exception $e) {
            $this->logger->error("Internal server error.", [$e->getMessage()]);

            return Result::fail(
                "Internal server error.",
                "CD001"
            );
        }
    }
}