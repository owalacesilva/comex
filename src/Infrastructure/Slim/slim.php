<?php

use Application\Enumerations\HttpStatusCode;
use Infrastructure\Slim\HttpNotFoundErrorHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Factory\AppFactory;
use Exception;

try {
    // Getting dependencies injection
    $dependenciesPath = Application::config('dependencies.php');
    $dependencies = require_once $dependenciesPath;

    if (!is_callable($dependencies)) {
        throw new RuntimeException('Dependencies configuration must return a callable');
    }

    // Build container and create app
    $container = $dependencies();

    // Create an application slim
    $app = AppFactory::createFromContainer($container);

    $routeCollector = $app->getRouteCollector();
    $routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

    // Load and apply routes and middleware
    foreach (['routes', 'middlewares'] as $type) {
        if ($handler = require_once __DIR__ . "/{$type}.php") {
            is_callable($handler) && $handler($app);
        }
    }

    $routeLogger = new Logger('error');
    $routeLogger->pushHandler(new RotatingFileHandler(
        Application::root('logs/errors.log')
    ));

    /**
     * The routing middleware should be added earlier than the ErrorMiddleware
     * Otherwise exceptions thrown from it will not be handled by the middleware
     */
    $app->addRoutingMiddleware();

    /**
     * Add Error Middleware
     *
     * @param bool                  $displayErrorDetails -> Should be set to false in production
     * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
     * @param bool                  $logErrorDetails -> Display error details in error log
     * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
     *
     * Note: This middleware should be added last. It will not handle any exceptions/errors
     * for middleware added after it.
     */
    $app->addErrorMiddleware(true,true,false, $routeLogger)
        ->setErrorHandler(
            HttpNotFoundException::class,
            new HttpNotFoundErrorHandler($app),
            true
        );

    $app->run();
} catch (Exception $e) {
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