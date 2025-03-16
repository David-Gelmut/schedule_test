<?php

namespace src;


class Console
{
    public static Console $console;
    public Database $database;
    public Migrations $migrations;
    public function __construct()
    {
        self::$console = $this;
        $this->database = Database::getInstance();
        $this->migrations = new Migrations();

    }

    public function migrateTables(): void
    {

        $this->migrations->runMigrations();
    }

    public function seedTables(): void
    {
        $this->migrations->runSeeds();
    }

    public function dropTables(): void
    {
        $this->migrations->deleteTables();
    }

    public function seedengSchedules(): void
    {
        $this->migrations->seedingSchedules();
    }

    public function buckupBase(): void
    {
        $this->database->backupBase();
    }

    public function buckupSite(): void
    {
        $this->database->backupSite();
    }
}