<?php

require_once __DIR__ . '/../vendor/autoload.php';
$appConf = require_once __DIR__ . '/../etc/app-conf.php';

// Костыль =====================================================================
if (!isset($_SERVER['PATH_INFO']) && isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/') {
    header('Location: /library');
    exit;
}
// =============================================================================

Model\Driver\Engine::setConnection('framework', $appConf['dbConfig']['main']);

AppFactory::create($appConf);
AppFactory::$instance->run();

// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
