<?php

use Infrastructure\Slim\Middlewares\CorsMiddleware;
use Slim\App;

return function (App $app) {
    $app->addMiddleware(new CorsMiddleware());
};
