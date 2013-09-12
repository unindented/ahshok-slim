<?php

error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('Ahshok\\', __DIR__);

define('APPLICATION_PATH', realpath(__DIR__ . '/..'));
