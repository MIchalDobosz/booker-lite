<?php

namespace App\Services;

use Carbon\CarbonInterval;

class ServiceService
{
    private int $interval;
    private CarbonInterval $maxDurationCarbonInterval;

    public function __construct()
    {
        $this->interval = (int) config('booker.interval', 15);

        $maxDuration = (int) config('booker.max_service_duration', 8);
        $this->maxDurationCarbonInterval = (new CarbonInterval(0))->addHours($maxDuration)->cascade();
    }

    public function getDurationOptions() : array
    {
        $carbonInterval = new CarbonInterval(0);

        while ($carbonInterval->lt($this->maxDurationCarbonInterval))
        {
            $carbonInterval->addMinutes($this->interval)->cascade();
            $availableSpots[] = $carbonInterval->format('%H:%I');
        }

        return $availableSpots ?? [];
    }
}
