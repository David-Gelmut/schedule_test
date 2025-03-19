<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once __DIR__ . '/config/core.php';
require_once __DIR__ . '/helpers/helpers.php';
setEnvData();
spl_autoload_register(function (string $classname) {
    require_once(ROOT . '/' . implode('/', explode('\\', $classname)) . '.php');
});
$console = new  \src\Console();
switch ($argv[1]){
    case 'migrate':
        $console->migrateTables();break;
    case 'delete':
        $console->dropTables();break;
    case 'seeding':
        $console->seedTables();break;
    case 'seeding_schedules':
        $console->seedengSchedules();break;
    case 'backup_base':
        $console->buckupBase();break;
    case 'backup_site':
        $console->buckupSite();break;
}