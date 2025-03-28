<?php

namespace models;

use src\Database;

class Region
{
    protected static string $table = 'regions';

    public static function getAllRegions(): array|false
    {
        return Database::getInstance()->findAll('regions');
    }

    public static function getRegionToID(int $idRegion): array|false
    {
        return Database::getInstance()->findOne(static::$table, $idRegion);
    }

    public static function getRegionDurationToID(int $idRegion): int
    {
        $region = Database::getInstance()->findOne(static::$table, $idRegion);
        return isset($region['duration']) ?: 0;
    }

    public static function getEndDateFromStart(int $idRegion, string $beginDate): int
    {
        return strtotime($beginDate) + static::getRegionDurationToID($idRegion) * 86400;
    }
}