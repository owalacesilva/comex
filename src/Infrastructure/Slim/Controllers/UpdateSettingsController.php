<?php

namespace Infrastructure\Slim\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Doctrine\Repositories\DoctrineSettingsRepository;
use InterfaceAdapter\UpdateSettingsInterfaceAdapter;
use OpenApi\Attributes as OA;
use Application\Traits\JsonResponseTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

#[OA\Put(
    path: "api/v1/settings",
    description: "Update settings.",
    summary: "Update settings.",
    security: ["barerAuth"],
    requestBody: new OA\RequestBody(
        description: "Setting data to update",
        required: true,
        content: [
            "application/json" => new OA\JsonContent(
                required: ["key", "value"],
                properties: [
                    new OA\Property(property: "key", description: "The key of the setting.", type: "string", example: "app_name"),
                    new OA\Property(property: "value", description: "The value of the setting.", type: "string", example: "My Application"),
                    new OA\Property(property: "description", description: "The description of the setting.", type: "string", example: "Application name setting"),
                ]
            )
        ]
    ),
    tags: ["Settings"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Setting updated successfully",
            content: [
                "application/json" => new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", description: "The ID of the setting.", type: "integer", example: 1),
                        new OA\Property(property: "key", description: "The key of the setting.", type: "string", example: "app_name"),
                        new OA\Property(property: "value", description: "The value of the setting.", type: "string", example: "My Application"),
                        new OA\Property(property: "description", description: "The description of the setting.", type: "string", example: "Application name setting"),
                    ]
                )
            ],
        ),
        new OA\Response(
            response: 404,
            description: "Setting not found"
        ),
        new OA\Response(
            response: 422,
            description: "Validation error"
        )
    ]
)]
final class UpdateSettingsController
{
    use JsonResponseTrait;

    public const VERSION = 1;

    /**
     * Constructor class
     *
     * @param LoggerInterface $logger Interface to logger service
     * @param EntityManagerInterface $entityManager Interface to manager entities
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $loggedUser = $request->getAttribute('loggedUser');;
        $payload = $request->getParsedBody() ?? [];

        $this->logger->info("Payload received.", $payload);

        $service = new UpdateSettingsInterfaceAdapter(
            $this->logger,
            new DoctrineSettingsRepository($this->entityManager),
        );

        $result = $service->execute($payload['settings'] ?? []);

        if ($result->isFail()) {
            return $this->error(
                $result->getErrorMessage(),
                $result->getErrorCode(),
                $result->getHttpStatusCode(),
            );
        }

        $this->entityManager->flush();

        return $this->success(
            "Setting successfully updated.",
            $result->getData()
        );
    }
}
