<?php

namespace InterfaceAdapter;

use Application\Enumerations\HttpStatusCode;
use Application\Exceptions\DomainException;
use Application\Helpers\Result;
use Application\Repositories\SettingsRepositoryInterface;
use Application\UseCases\UpdateSettingsUseCase;
use Domain\Entities\SettingEntity;
use InterfaceAdapter\Presenters\UpdateSettingsPresenter;
use InterfaceAdapter\Validators\UpdateSettingValidator;
use Psr\Log\LoggerInterface;
use Exception;

/**
 * Class responsible for adapting the interface between the HTTP layer and the use case layer
 * for updating settings functionality
 */
class UpdateSettingsInterfaceAdapter
{
    private UpdateSettingsUseCase $useCase;

    /**
     * Creates a new UpdateSettingsInterfaceAdapter instance
     *
     * @param LoggerInterface $logger Interface to logger service
     * @param SettingsRepositoryInterface $settingsRepository Interface to settings repository
     */
    public function __construct(
        private readonly LoggerInterface             $logger,
        private readonly SettingsRepositoryInterface $settingsRepository
    )
    {
        $this->useCase = new UpdateSettingsUseCase(
            $this->logger,
            $this->settingsRepository,
        );
    }

    /**
     * Executes the use case to update a setting
     *
     * @param array $settings The settings to update
     * @return Result The result
     */
    public function execute(array $settings): Result
    {
        $this->logger->info("Update setting");

        $validator = new UpdateSettingValidator($settings);
        if (!$validator->validate()) {
            $this->logger->error("Validation error.", ['errors' => $validator->getErrors()]);
            return Result::fail(
                $validator->getErrors(),
                "CD004",
                HttpStatusCode::BAD_REQUEST
            );
        }

        try {
            $settingEntities = array_map(function ($key, $value) {
                return new SettingEntity(
                    null,
                    key: $key,
                    value: $value
                );
            }, array_keys($settings), array_values($settings));

            $updatedSettings = $this->useCase->execute($settingEntities);

            $presenter = new UpdateSettingsPresenter($updatedSettings);

            return Result::ok($presenter->present());
        } catch (DomainException $e) {
            $this->logger->error("Failed to update setting.", ['error' => $e->getMessage()]);

            return Result::fail($e->getMessage(), "CD003", HttpStatusCode::UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            $this->logger->error("Internal server error.", ['error' => $e->getMessage()]);

            return Result::fail("Internal server error.", "CD001");
        }
    }
}
