<?php

namespace Infrastructure\Slim\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Doctrine\Repositories\DoctrineSettingsRepository;
use InterfaceAdapter\ListSettingsInterfaceAdapter;
use OpenApi\Attributes as OA;
use Application\Traits\JsonResponseTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

#[OA\Get(
    path: "api/v1/settings",
    description: "Get a list of settings.",
    summary: "Get a list of settings.",
    security: ["barerAuth"],
    tags: ["Settings"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Success",
            content: [
                "application/json" => new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", description: "The ID of the setting.", type: "integer", example: 1),
                        new OA\Property(property: "key", description: "The key of the setting.", type: "string", example: "foo"),
                        new OA\Property(property: "value", description: "The value of the setting.", type: "string", example: "foo"),
                    ]
                )
            ],
        )
    ]
)]
final class ListSettingsController
{
    use JsonResponseTrait;

    public const VERSION = 1;

    /**
     * Constructor class
     *
     * @param LoggerInterface $logger InterfaceAdapter to logger service
     * @param EntityManagerInterface $entityManager Interface to manager entities
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $service = new ListSettingsInterfaceAdapter(
            $this->logger,
            new DoctrineSettingsRepository($this->entityManager),
        );

        $result = $service->execute();

        if ($result->isFail()) {
            return $this->error(
                $result->getErrorMessage(),
                $result->getErrorCode(),
                $result->getHttpStatusCode(),
            );
        }

        return $this->success(
            "Settings successfully listing.",
            $result->getData()
        );
    }
}