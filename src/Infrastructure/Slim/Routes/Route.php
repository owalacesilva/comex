<?php

/**
 * Abstract class representing a base route configuration.
 * Classes extending this abstract class must define the method
 * for adding routes to the application.
 */

namespace Infrastructure\Slim\Routes;

use Slim\App;

/**
 * Represents an abstract Route that can be extended to define application routes.
 */
abstract class Route
{
    public function __construct(protected App $route) {}

    abstract public function addRoutes();
}