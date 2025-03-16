<?php

use src\Application;
use src\Console;

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

function base_url(string $path): string
{
    return ROOT . "/{$path}";
}

function addDays(string $date, int $day): string
{
    return strtotime($date) + $day * 86400;
}