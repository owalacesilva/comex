<?php

namespace Infrastructure\Slim\Controllers;

use Application\Traits\JsonResponseTrait;
use http\Exception\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * @OA\Get(
 *     path="/health",
 *     summary="Health Check",
 *     tags={"Overview"},
 *     description="Endpoint for monitoring the API service health status. Returns basic system information including service status, current timestamp, PHP version, and memory usage. This endpoint can be used for monitoring, load balancing, and service availability checks.",
 *     @OA\Response(
 *         response="200",
 *         description="Service health information",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="healthy"),
 *             @OA\Property(property="timestamp", type="integer", example=1692806400),
 *             @OA\Property(property="php_version", type="string", example="8.4.0"),
 *             @OA\Property(property="memory_usage", type="integer", example=2097152)
 *         )
 *     )
 * )
 */
final class HealthCheckController extends BaseController
{
    use JsonResponseTrait;

    public function __construct(private readonly LoggerInterface $logger) {}

    /**
     * Handles the incoming request and prepares a response.
     *
     * @param Request $request The incoming HTTP request.
     * @param Response $response The HTTP response instance to be filled.
     *
     * @return ResponseInterface The HTTP response containing the service status and additional information.
     */
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $data = [
            'status' => 'healthy',
            'timestamp' => time(),
            'php_version' => PHP_VERSION,
            'memory_usage' => memory_get_usage(true)
        ];

        $this->logger->info('Health check.', $data);

        return $this->success('Service is running', $data);
    }
}