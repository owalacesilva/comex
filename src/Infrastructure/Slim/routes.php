<?php

use Infrastructure\Slim\Routes\HealthCheckRoute;
use Slim\App;

return function (App $app)
{
    $app->get('/', function ($request, $response, $args) {
        return $response->withStatus(200);
    });

    $healthCheckRoute = new HealthCheckRoute($app);
    $healthCheckRoute->addRoutes();
};
