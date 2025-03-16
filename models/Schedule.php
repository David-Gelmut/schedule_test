<?php

namespace models;

use src\Database;

class Schedule
{
    protected static string $table = 'schedules';

    public static function getSchedulesWithRegionsAndCouriers(): array|false
    {
        return Database::getInstance()
            ->select(['schedules.id', 'schedules.date', 'regions.title', 'couriers.name', 'regions.duration'])
            ->join('schedules', 'regions', 'region_id', 'id')
            ->join('schedules', 'couriers', 'courier_id', 'id')
            ->orderBy('date','DESC')
            ->get('schedules');
    }
    //Получаем расписание курьера с id = $idCourier который в данный период с $dateBegin по $dateEnd занят
    //Если не получаем записи для этого курьера то делаем новую запись раписания в базу
    public static function getScheduleCourierForPeriodTime(int $idCourier, string $dateBegin, int $dateEnd): array|false
    {
        return Database::getInstance()->select(['schedules.date', 'couriers.id','couriers.name',  'regions.duration','regions.title', 'regions.duration * 86400 + UNIX_TIMESTAMP(schedules.date) AS date_end'])
            ->join('schedules', 'regions', 'region_id', 'id')
            ->join('schedules', 'couriers', 'courier_id', 'id')
            ->where('couriers.id', '=', $idCourier)
            ->whereAnd('UNIX_TIMESTAMP(schedules.date)', '<=', $dateEnd)
            ->having('date_end', '>=', strtotime($dateBegin) )
            ->get('schedules');
    }

    public static function getScheduleForPeriodTime(string $dateBegin, string $dateEnd): array|int
    {
        return Database::getInstance()
            ->select(['schedules.id', 'schedules.date', 'regions.title', 'couriers.name', 'regions.duration'])
            ->join('schedules', 'regions', 'region_id', 'id')
            ->join('schedules', 'couriers', 'courier_id', 'id')
            ->where('UNIX_TIMESTAMP(schedules.date)', '>',  strtotime($dateBegin))
            ->whereAnd('UNIX_TIMESTAMP(schedules.date)', '<',  strtotime($dateEnd))
            ->orderBy('date','DESC')
            ->get('schedules');
    }
}