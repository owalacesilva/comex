<?php

use Application\Enumerations\HttpStatusCode;
use Infrastructure\Slim\Controllers\ListSettingsController;
use Infrastructure\Slim\Controllers\UpdateSettingsController;
use Infrastructure\Slim\Routes\HealthCheckRoute;
use OpenApi\Generator;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

return function (App $app)
{
    $app->get('/', function ($request, $response) {
        return $response->withStatus(200);
    })->setName('home');

    $app->get('/routes', function ($request, $response) use ($app) {
        $routeCollector = $app->getRouteCollector();
        $routes = $routeCollector->getRoutes();

        $routeData = [];
        foreach ($routes as $route) {
            $routeData[] = [
                'name' => $route->getName() ?: 'unnamed',
                'pattern' => $route->getPattern(),
                'methods' => $route->getMethods(),
                'callable' => $route->getCallable(),
                'groups' => $route->getGroups()
            ];
        }

        $response->getBody()->write(json_encode($routeData, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    });

    $app->get('/swagger.json', function ($request, $response): ResponseInterface {
        $openapi = Generator::scan([Application::src('Infrastructure/Slim/Validators')]);

        $response->getBody()->write($openapi->toJson());
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    })->setName('swagger');

    $app->get('/api/docs', function ($request, $response) {
        $html = file_get_contents(Application::root('public/swagger.html'));
        $response->getBody()->write($html);

        return $response
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    })->setName('api-docs');

    $healthCheckRoute = new HealthCheckRoute($app);
    $healthCheckRoute->addRoutes();

    $app->group('/api', function ($collector) {
        $collector->get(
            sprintf('/v%d/settings', ListSettingsController::VERSION),
            ListSettingsController::class
        )->setName('settings.list');

        $collector->put(
            sprintf('/v%d/settings', UpdateSettingsController::VERSION),
            UpdateSettingsController::class
        )->setName('settings.get');
    });
};
