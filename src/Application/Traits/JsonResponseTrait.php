<?php

namespace Application\Traits;

use Application\Enumerations\HttpStatusCode;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

trait JsonResponseTrait
{
    /**
     * Creates a success response with the given message and data
     *
     * @param string $message Success message to include in the response
     * @param mixed $data Optional data to include in the response
     * @param int $statusCode HTTP status code for the response (default: 200 OK)
     * @return ResponseInterface PSR-7 response object
     */
    public function success(string $message, mixed $data = [], int $statusCode = HttpStatusCode::OK): ResponseInterface
    {
        $response = [
            'message' => $message ?? 'Success',
            'data' => $data,
        ];

        return $this->json($response, $statusCode);
    }

    /**
     * Creates an error response with the given error message and code
     *
     * @param string|array|null $message Error message or messages to include in the response
     * @param string $internalErrorCode Internal error code for tracking/debugging
     * @param int $statusCode HTTP status code for the response (default: 500 Internal Server Error)
     * @return ResponseInterface PSR-7 response object
     */
    public function error(string|array|null $message, string $internalErrorCode = 'INTERNAL_ERROR', int $statusCode = HttpStatusCode::INTERNAL_SERVER_ERROR): ResponseInterface
    {
        $response = [
            'error' => $message ?? 'An unexpected error occurred. Please try again later.',
            'code' => $internalErrorCode,
        ];

        return $this->json($response, $statusCode);
    }

    /**
     * Converts array data to a JSON response with security headers
     *
     * @param array $response Array of data to convert to JSON
     * @param int $statusCode HTTP status code for the response
     * @return ResponseInterface PSR-7 response object with JSON content and security headers
     */
    public function json(array $response, int $statusCode): ResponseInterface
    {
        $jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $response = new Response();
        $response->getBody()->write($jsonResponse);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Content-Type-Options', 'nosniff')
            ->withHeader('X-XSS-Protection', '1; mode=block')
            ->withHeader('X-Frame-Options', 'SAMEORIGIN')
            ->withHeader('Content-Length', strlen($jsonResponse))
            ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Expires', '0')
            ->withHeader('X-Powered-By', 'PHP/' . phpversion())
            ->withHeader('X-Debug-Token', 'debug-token')
            ->withStatus($statusCode);
    }
}