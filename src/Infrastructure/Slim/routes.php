<?php

use Application\Enumerations\HttpStatusCode;
use Infrastructure\Slim\Routes\HealthCheckRoute;
use OpenApi\Generator;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

return function (App $app)
{
    $app->get('/', function ($request, $response, $args) {
        return $response->withStatus(200);
    });

    $app->get('/swagger.json', function ($request, $response, $args): ResponseInterface {
        $openapi = Generator::scan([__DIR__  . '/Controllers']);

        $response->getBody()->write($openapi->toJson());
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    });

    $app->get('/api/docs', function ($request, $response, $args) {
        $html = file_get_contents(__DIR__ . '/../../../public/swagger.html');
        $response->getBody()->write($html);

        return $response
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withStatus(HttpStatusCode::OK);
    });

    $healthCheckRoute = new HealthCheckRoute($app);
    $healthCheckRoute->addRoutes();
};
