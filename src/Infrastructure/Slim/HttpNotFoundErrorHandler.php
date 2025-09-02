<?php

namespace Infrastructure\Slim;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

readonly class HttpNotFoundErrorHandler implements ErrorHandlerInterface
{
    public function __construct(private App $app) {}

    public function __invoke(
        ServerRequestInterface $request,
        Throwable              $exception,
        bool                   $displayErrorDetails,
        bool                   $logErrors,
        bool                   $logErrorDetails
    ): ResponseInterface
    {
        $response = $this->app->getResponseFactory()->createResponse(404);
        $response->getBody()->write("<h1>404 - Page Not Found</h1><p>The requested page could not be found.</p>");

        return $response;
    }
}