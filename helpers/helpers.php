<?php

use src\Application;
use src\Console;
use src\View;

function app(): Application
{
    return Application::$app;
}

function console(): Console
{
    return Console::$console;
}

function dd(mixed $vars): never
{
    echo '<pre>';
    print_r($vars);
    echo '<pre>';;
    die();
}

function response(): \src\Response
{
    return app()->response;
}

function base_url(string $path): string
{
    return ROOT . "/{$path}";
}

function addDays(string $date, int $day): string
{
    return strtotime($date) + $day * 86400;
}

function setEnvData(string $filePath = ''): void
{
    if (empty($filePath)) {
        $filePath = __DIR__ . '/../.env';
    }
    $file = file_get_contents($filePath);
    $data = explode(PHP_EOL, $file);
    if (empty($data)) {
        return;
    }
    foreach ($data as $item) {
        putenv(trim($item));
    }
}

function env(string $envParam): array|false|string
{
    return getenv($envParam);
}
