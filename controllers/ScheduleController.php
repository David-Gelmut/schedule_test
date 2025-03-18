<?php

namespace controllers;


use models\Region;
use models\Schedule;
use src\Database;
use src\Log;
use src\Request;

class ScheduleController
{
    public function index(): void
    {
        $schedulesIndex = Schedule::getSchedulesWithRegionsAndCouriers();
        include ROOT . '/views/schedules/index.php';
    }

    public function store(array $request): array
    {
        $dateEnd = Region::getEndDateFromStart($request['region_id'], ($request['date']));
        $schedulesIndex = Schedule::getScheduleCourierForPeriodTime($request['courier_id'], ($request['date']), $dateEnd);
        if (count($schedulesIndex) != 0) {
            return [
                'status' => false, 'data' => $schedulesIndex
            ];
        }

        $idSavedScheduler = Database::getInstance()->insert('schedules', $request);
        if ($idSavedScheduler === 0) {
            return [
                'status' => true
            ];
        }
        return [
            'status' => false,
        ];
    }

    public function filter(array $request): string
    {
        $schedulesIndex = Schedule::getScheduleForPeriodTime($request['start'], $request['end']);
        return include ROOT . '/views/schedules/index.php';
    }
}