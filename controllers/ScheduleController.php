<?php

namespace controllers;

use models\Courier;
use models\Region;
use models\Schedule;
use src\Database;

class ScheduleController extends Controller
{
    public function index(): \src\View|string
    {
        $schedulesIndex = Schedule::getSchedulesWithRegionsAndCouriers();
        $couriers = Courier::getAllCouriers();
        $regions = Region::getAllRegions();
        return $this->view->render('schedules/index', compact('schedulesIndex', 'couriers', 'regions'));
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

    public function filter(array $request): string|false
    {
        $schedulesIndex = Schedule::getScheduleForPeriodTime($request['start'], $request['end']);
        return $this->view->renderPartial('schedules/index', compact('schedulesIndex'));
    }
}