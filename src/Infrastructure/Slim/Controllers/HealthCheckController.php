<?php

namespace Application\Controllers;

use Application\Traits\JsonResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class HealthCheckController extends BaseController
{
    use JsonResponseTrait;

    /**
     * Handles the incoming request and prepares a response.
     *
     * @param Request $request The incoming HTTP request.
     * @param Response $response The HTTP response instance to be filled.
     * @param array $args An array of route parameters extracted from the request.
     *
     * @return ResponseInterface The HTTP response containing the service status and additional information.
     */
    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        $data = [
            'status' => 'healthy',
            'timestamp' => time(),
            'php_version' => PHP_VERSION,
            'memory_usage' => memory_get_usage(true)
        ];

        return $this->success('Service is running', $data);
    }
}