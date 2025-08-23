<?php

$autoloadFile = '../vendor/autoload.php';

if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run this project.');
}

require_once $autoloadFile;

require_once '../src/application.php';