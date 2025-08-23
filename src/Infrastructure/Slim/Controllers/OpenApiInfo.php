<?php

namespace Infrastructure\Slim\Controllers;

/**
 * Global OpenAPI specification metadata.
 *
 * @OA\Info(
 *     title="API Comex",
 *     version="1.0.0",
 *     description="Public HTTP API."
 * )
 * @OA\Server(
 *     url="/",
 *     description="Default application server"
 * )
 */
abstract class OpenApiInfo
{
    /**
     * Returns OpenAPI specification metadata for the API documentation.
     *
     * @return array OpenAPI specification metadata including title, version, description etc.
     */
    public function getOpenApiInfo(): array
    {
        return [
            'title' => 'API Comex',
            'version' => '1.0.0',
            'description' => 'Public HTTP API.',
            'servers' => [
                [
                    'url' => '/',
                    'description' => 'Default application server'
                ]
            ]
        ];
    }
}