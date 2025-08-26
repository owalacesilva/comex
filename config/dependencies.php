<?php

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $container) {
            $logger = new Logger('app');

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $fileHandler = new StreamHandler(
                Application::root('logs/app.log')
            );

            $logger->pushHandler($fileHandler);

            return $logger;
        }
    ]);
};