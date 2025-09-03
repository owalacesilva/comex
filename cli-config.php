<?php

require_once 'config/initialize.php';
require_once 'config/application.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\YamlFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;

// Getting dependencies injection
$dependenciesPath = Application::config('dependencies.php');
$dependencies = require_once $dependenciesPath;

if (!is_callable($dependencies)) {
    throw new RuntimeException('Dependencies configuration must return a callable');
}

// Build container and get entity manager
$container = $dependencies();
$entityManager = $container->get(EntityManagerInterface::class);

return DependencyFactory::fromEntityManager(
    new YamlFile('migrations.yml'),
    new ExistingEntityManager($entityManager)
);