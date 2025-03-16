<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once __DIR__ . '/../config/core.php';
require_once __DIR__ . '/../helpers/helpers.php';

spl_autoload_register(function (string $classname) {
    require_once(ROOT . '/' . implode('/', explode('\\', $classname)) . '.php');
});

$app = new \src\Application();
require_once ROOT . '/views/layouts/main.php';
$app->run();



