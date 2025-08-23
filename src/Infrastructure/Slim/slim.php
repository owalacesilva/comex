<?php

use Application\Enumerations\HttpStatusCode;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

try {
    // Initialize container builder
    $containerBuilder = new ContainerBuilder();

    // Define configuration files
    $configFiles = [
        'dependencies' => __DIR__ . '/dependencies.php',
        'repositories' => __DIR__ . '/repositories.php',
    ];

    // Load and apply configurations
    array_walk($configFiles, function ($file) use ($containerBuilder) {
        if ($config = require_once $file) {
            is_callable($config) && $config($containerBuilder);
        }
    });

    // Build container and create app
    $container = $containerBuilder->build();

    // Create an application slim
    $app = AppFactory::createFromContainer($container);

    // Load and apply routes and middleware
    foreach (['routes', 'middlewares'] as $type) {
        if ($handler = require_once __DIR__ . "/{$type}.php") {
            is_callable($handler) && $handler($app);
        }
    }

    $app->run();
} catch (\Exception $e) {
    if (getenv('APP_ENV') === 'development') {
        error_log($e->getMessage());
        var_dump([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
    } else {
        error_log('Application Error: ' . $e->getMessage());
        http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR);
        echo 'An error occurred. Please try again later.';
    }
}