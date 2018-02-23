<?php

namespace App;

use DB;

class BusWork
{
    public $works = [];
    public $busNumber = [];

    public function __construct($busNumber, $ride = null)
    {
        $this->busNumber = $busNumber;

        return $this->addWork($ride);
    }

    /**
     * Добавление рабочей смены
     * @param $ride
     * @return array
     */
    public function addWork($ride)
    {
        $workNum = (int) $ride['smena'];

        $this->works[$workNum] = json_decode(json_encode($ride), true)['event'];

        ksort($this->works);

        return $this->works;
    }

    /**
     * 2. количество производственных рейсов, общее время производственных рейсов
     * @return array
     */
    public function getRidesStats()
    {
        $duration = function ($arr) {
            return $arr['@attributes']['ev_id'] == 4 ? $arr['@attributes']['duration'] : 0;
        };

        $pathToRide = function ($work) use ($duration) {
            return array_sum(array_map($duration, $work));
        };

        $isProduction = function ($ride) {
            return (int) $ride['@attributes']['ev_id'] == 4;
        };

        $countsOfRides = function ($work) use ($isProduction) {
            return array_sum(array_map($isProduction, $work));
        };

        return ['ridesCount' => array_sum(array_map($countsOfRides, $this->works)), 'duration' => array_sum(array_map($pathToRide, $this->works))];
    }

    /**
     * Производственные остановки в указанный промежуток времени
     * @param $from
     * @param $to
     * @return array
     */
    public function getStopsByTime($from, $to)
    {
        $seconds = function ($time) {
            list($hours, $mins) = explode(':', $time);
            return ($hours * 3600 ) + ($mins * 60 );
        };

        $stopsName = $this->getDescriptionsForRides();

        $from = $seconds($from);
        $to = $seconds($to);
        $resultStops = [];
        $workNum = 1;
        $rideNum = 0; //порядковый номер рейса

        $checkStops = function ($stop, $num) use ($to, $seconds, &$resultStops, &$workNum, &$rideNum, $stopsName){
            $workNum = $num ? $num : $workNum;

            $time = $seconds($stop['@attributes']['time']);
            if ($time <= $to) {
                $stop = $stop['@attributes'];
                $stop['name'] = isset($stopsName[$stop['st_id']]) ? $stopsName[$stop['st_id']] : '';
                $stop['workNum'] = $workNum;
                $stop['rideNum'] = $rideNum;
                $resultStops[] = $stop;
            }
        };

        $checkRide = function ($ride, $num) use ($from, $seconds, $checkStops, &$workNum, &$rideNum) {
            $workNum = $num ? $num : $workNum;
            $rideNum ++;

            if ($ride['@attributes']['ev_id'] == 4 && $seconds($ride['@attributes']['start']) >= $from)
                return array_map($checkStops, $ride['stop'], [$workNum]);
        };

        foreach ($this->works as $workNum => $work) {
            array_map($checkRide, $work, [$workNum]);
        }

        return $resultStops;
    }

    /**
     * Номера остановок и их наименование.
     * @return mixed
     */
    public function getDescriptionsForRides()
    {
        return DB::table('StopPoints')->pluck('name', 'external_id')->toArray(); //Можно было бы и через ORM
    }

}