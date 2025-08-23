<?php

namespace Infrastructure\Slim\Routes;

use Infrastructure\Slim\Controllers\HealthCheckController;

class HealthCheckRoute extends Route
{
    public function addRoutes(): void
    {
        $this->route->get('/health', HealthCheckController::class)
            ->setName('health');
    }
}