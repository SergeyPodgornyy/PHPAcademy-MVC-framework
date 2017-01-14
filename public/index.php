<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
$appConf = require_once __DIR__ . '/../etc/app-conf.php';

if (isset($_SESSION['Lang'])) {
    Utils\Context::setLang($_SESSION['Lang']);
}

Model\Driver\Engine::setConnection('framework', $appConf['dbConfig']['main']);

AppFactory::create($appConf);
AppFactory::$instance->run();
