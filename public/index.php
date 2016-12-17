<?php

require_once __DIR__ . '/../vendor/autoload.php';
$appConf = require_once __DIR__ . '/../etc/app-conf.php';

AppFactory::create($appConf);
AppFactory::$instance->run();

// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
