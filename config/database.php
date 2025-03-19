<?php
$config_database = [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env("DB_HOST"),
        'database' => env("DB_DATABASE"),
        'user' => env("DB_USERNAME"),
        'password' => env("DB_PASSWORD"),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'port' => 3306,
        'prefix' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    ]
];