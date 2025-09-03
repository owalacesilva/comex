<?php

use Application\Interfaces\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Infrastructure\Settings\EnvSettings;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

$definitions = [
    /**
     * Instantiate a settings implementation as Dependency.
     */
    SettingsInterface::class => DI\create(EnvSettings::class),

    /**
     * Creates a PSR-3 compatible Logger instance for application logging
     *
     * Configures Monolog with:
     * - Unique request ID processor
     * - Stream handler writing to app.log
     *
     * @return Logger PSR-3 logger instance
     */
    LoggerInterface::class => function (ContainerInterface $container) {
        $logger = new Logger('app');

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $fileHandler = new StreamHandler(
            Application::root('logs/app.log')
        );

        $logger->pushHandler($fileHandler);

        return $logger;
    },

    /**
     * Creates and configures a Doctrine EntityManager instance.
     *
     * Configures the EntityManager with:
     * - Doctrine attribute metadata configuration pointing to models directory
     * - Database connection settings from application configuration
     * - Development mode enabled
     *
     * @param ContainerInterface $container DI container to get settings from
     * @return EntityManager Configured EntityManager instance
     */
    EntityManagerInterface::class => function (ContainerInterface $container) {
        $settings = $container->get(SettingsInterface::class);

        $ormConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: [Application::src('Infrastructure/Doctrine/Models')],
            isDevMode: true,
        );

        $connection = DriverManager::getConnection([
            'driver' => $settings->get('db.driver'),
            'host' => $settings->get('db.host'),
            'port' => $settings->get('db.port'),
            'dbname' => $settings->get('db.database'),
            'user' => $settings->get('db.username'),
            'password' => $settings->get('db.password'),
            'charset' => $settings->get('db.charset'),
        ], $ormConfig);

        return new EntityManager($connection, $ormConfig);
    },
];

return static function () use ($definitions) {
    // Initialize container builder
    $containerBuilder = new ContainerBuilder();

    // Add definitions
    $containerBuilder->addDefinitions($definitions);

    // Build e return the container
    return $containerBuilder->build();
};