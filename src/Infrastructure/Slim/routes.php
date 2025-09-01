<?php

use Application\Enumerations\HttpStatusCode;
use Infrastructure\Slim\Routes\HealthCheckRoute;
use OpenApi\Generator;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

return function (App $app)
{
    $app->get('/', function ($request, $response) {
        return $response->withStatus(200);
    });

    $app->get('/swagger.json', function ($request, $response): ResponseInterface {
        $openapi = Generator::scan([Application::src('Infrastructure/Slim/Controllers')]);

        $response->getBody()->write($openapi->toJson());
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    });

    $app->get('/api/docs', function ($request, $response) {
        $html = file_get_contents(Application::root('public/swagger.html'));
        $response->getBody()->write($html);

        return $response
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    });

    $healthCheckRoute = new HealthCheckRoute($app);
    $healthCheckRoute->addRoutes();
};
