<?php
define("ROOT", dirname(__DIR__));
const SITE_URL = 'http://localhost:8080';
const DB_SETTINGS = [
    'driver' => 'mysql',
   // 'host' => 'db',
    'host' => 'localhost',
   // 'database' => 'db_name',
    'database' => 'database_test',
    'user' => 'root',
    //'password' => 'root',
    'password' => '12345',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'port' => 3306,
    'prefix' => '',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
];