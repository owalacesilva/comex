<?php

$autoloadFile = '../vendor/autoload.php';

if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run this project.');
}

require_once $autoloadFile;

try {
    if (!file_exists(__DIR__ . '/../.env')) {
        throw new \RuntimeException('Environment file (.env) not found. Please copy .env.example to .env and configure your environment settings.');
    }

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} catch (
    \Dotenv\Exception\InvalidEncodingException|
    \Dotenv\Exception\InvalidFileException|
    \Dotenv\Exception\InvalidPathException $e
) {
    var_dump($e);
    if (getenv('APP_DEBUG') !== null && getenv('APP_DEBUG')) {
        echo sprintf(
            'Environment configuration error: %s in %s on line %d',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
    } else {
        echo 'Application configuration error. Please contact system administrator.';
    }
    exit(1);
}

require_once '../config/application.php';