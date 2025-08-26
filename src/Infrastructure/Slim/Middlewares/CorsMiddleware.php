<?php

namespace Infrastructure\Slim\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware to handle Cross-Origin Resource Sharing (CORS) headers.
 *
 * This middleware intercepts HTTP requests and attaches the appropriate
 * CORS headers to the response. These headers determine how the server
 * will handle requests from different origins, allowing or restricting access
 * based on the specified configuration.
 *
 * By default, this middleware:
 * - Allows requests from all origins
 * - Permits headers such as 'X-Requested-With', 'Content-Type', 'Accept', 'Origin', 'Authorization'
 * - Supports HTTP methods including GET, POST, PUT, DELETE, PATCH, and OPTIONS
 * - Enables credentials to be included in requests
 * - Specifies a pre-flight cache duration using the Access-Control-Max-Age header
 */
class CorsMiddleware implements MiddlewareInterface {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '3600');
    }
}