<?php

namespace Infrastructure\Slim\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Public HTTP API",
    title: "API Comex"
)]
#[OA\Server(
    url: "/",
    description: "Default application server"
)]
#[OA\PathItem(
    path: "/",
    summary: "Root path",
    description: "Root path"
)]
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