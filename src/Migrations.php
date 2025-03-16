<?php

namespace src;

class Migrations
{
    private Database $database;

    private string $migrationDir = ROOT . '/db/migrations/';
    private string $seedsDir = ROOT . '/db/seeds/';
    const  MIGRATIONS_TABLE = 'migrations';

    public function __construct()
    {
        $this->database = console()->database;
    }

    public function runMigrations(): void
    {

        foreach ($this->getMigrationsFile() as $file) {
            $this->migrate($file);
        }
    }

    public function runSeeds(): void
    {
        foreach ($this->getSeedsFile() as $file) {
            $this->seeding($file);
        }
    }

    public function deleteTables(): void
    {
        $query = 'SHOW TABLES';
        $data = $this->database->query($query)->findAll(self::MIGRATIONS_TABLE);
        $data = array_reverse($data);
        foreach ($data as $row) {
            $tableName = explode('_', pathinfo($row['name'], PATHINFO_FILENAME))[1];
            $query = 'DROP TABLE IF EXISTS `' . $tableName . '`';
            $this->database->query($query);
        }
    }

    private function getMigrationsFile(): array
    {
        $allFiles = glob($this->migrationDir . '*.sql');

        $query = 'SHOW TABLES FROM `' . DB_SETTINGS['database'] . '` LIKE "' . self::MIGRATIONS_TABLE . '"';

        if (!$this->database->query($query)->rowCount()) {
            return $allFiles;
        };

        $currentMigrationsInTable = [];
        $data = $this->database->query($query)->findAll(self::MIGRATIONS_TABLE);

        foreach ($data as $row) {
            $currentMigrationsInTable[] = $this->migrationDir . $row['name'];
        }
        return array_diff($allFiles, $currentMigrationsInTable);
    }

    private function getSeedsFile(): array
    {
        return glob($this->seedsDir . '*.sql');
    }

    private function migrate($file): void
    {
        $sql = file_get_contents($file);
        $this->database->query($sql);
        //$command = sprintf("mysql -u%s -p%s -h %s -D %s < %s", DB_SETTINGS['user'], DB_SETTINGS['password'], DB_SETTINGS['host'], DB_SETTINGS['database'], $file);
      //  shell_exec($command);
    //    dd($this->getMigrationsFile());
        $query = 'INSERT INTO `' . self::MIGRATIONS_TABLE . '` (`name`) VALUES ("' . basename($file) . '")';
        $this->database->query($query);
    }

    private function seeding($file): void
    {
        $sql = file_get_contents($file);
        $this->database->query($sql);
       // $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', DB_SETTINGS['user'], DB_SETTINGS['password'], DB_SETTINGS['host'], DB_SETTINGS['database'], $file);
       // shell_exec($command);

    }

    public function seedingSchedules(): void
    {
        $result = [];
        $dateEnd = time() + 3 * 30 * 86400;
        $regions = Database::getInstance()->select(['id', 'duration'])->get('regions');
        $couriers = Database::getInstance()->select(['id'])->get('couriers');
        shuffle($couriers);

        foreach ($couriers as $courier) {
            $courierId = $courier['id'];
            for ( $dateBegin = time(); $dateBegin <= $dateEnd;) {

                $regionIdx = random_int(0,count($regions)-1);
                $regionId = $regions[$regionIdx]['id'];
                $regionDuration =  $regions[$regionIdx]['duration'];
                $result[] = [$regionId, $courierId, date('Y-m-d', $dateBegin)];

                $dateBegin += $regionDuration * 86400;
            }
        }
        Database::getInstance()->insertMany('schedules',['region_id','courier_id','date'],$result);
    }
}