<?php

namespace Application\Routes;

use Application\Controllers\HealthCheckController;

class HealthCheckRoute extends Route
{
    public function addRoutes(): void
    {
        $this->route->get('/health', HealthCheckController::class)
            ->setName('health');
    }
}