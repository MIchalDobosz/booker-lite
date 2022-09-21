<?php

namespace App\Services;

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;

class ReservationService
{
    private int $interval;
    private int $weeks;
    private Carbon $carbon;
    private Carbon $maxCarbon;
    private CarbonInterval $minCarbonInterval;
    private CarbonInterval $maxCarbonInterval;

    public function __construct()
    {
        $this->interval = (int) config('booker.interval', 15);
        $this->weeks = (int) config('booker.max_reservation_time', 4);
        $this->carbon = $this->getCarbonForNextInterval();
        $this->maxCarbon = $this->carbon->copy()->addWeeks($this->weeks)->endOfDay();
        $this->minCarbonInterval = (new CarbonInterval(0))->addHours(8)->cascade(); // do konfiguracji
        $this->maxCarbonInterval = (new CarbonInterval(0))->addHours(16)->cascade(); // do konfiguracji
    }

    public function getAvailableSpots() : array
    {
        while ($this->carbon->lt($this->maxCarbon))
        {
            if ($this->isIntervalAvailable()) continue;

            $availableSpots[$this->carbon->format('d-m-Y')][] = $this->carbon->format('H:i');
            $this->carbon->addMinutes($this->interval);
        }

        return $availableSpots ?? [];
    }

    public function getCarbonForNextInterval() : Carbon
    {
        if (!empty($this->carbon)) return $this->carbon;

        $carbon = Carbon::now()->startOfMinute();
        $carbonMinutes = (int) $carbon->format('i');

        $interval = $this->interval;
        while ($interval < $carbonMinutes)
            $interval += $this->interval;

        $carbon->minutes($interval);

        return $carbon;
    }

    private function isIntervalAvailable() : bool
    {
        $carbonInterval = $this->carbon->diffAsCarbonInterval($this->carbon->copy()->startOfDay());

        if ($carbonInterval->lt($this->minCarbonInterval))
        {
            $this->carbon->setTime(0, $this->minCarbonInterval->totalMinutes);
            return true;
        }
        else if ($carbonInterval->gt($this->maxCarbonInterval))
        {
            $this->carbon->addDay()->setTime(0, $this->minCarbonInterval->totalMinutes);
            return true;
        }

        return false;
    }
}
