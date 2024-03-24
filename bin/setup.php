<?php

use App\CommandController;
use App\Components\Containers\ConfigurationContainer;

require_once __DIR__ . '/../vendor/autoload.php';
$configuration = require_once __DIR__ . '/../configuration.php';

if (php_sapi_name() !== 'cli') {
    exit;
}

$command = new CommandController(new ConfigurationContainer($configuration));
$command->setup();