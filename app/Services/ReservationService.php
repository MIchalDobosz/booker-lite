<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ReservationService
{
    private int $interval;
    private int $weeks;
    private Service $service;
    private CarbonInterval $serviceDuration;
    private Carbon $carbon;
    private Carbon $maxCarbon;
    private CarbonInterval $minCarbonInterval;
    private CarbonInterval $maxCarbonInterval;
    private array $employeeIds;
    private Collection $reservations;

    public function __construct(Service $service, ?Employee $employee = null)
    {
        $this->interval = (int) config('booker.interval', 15);
        $this->weeks = (int) config('booker.max_reservation_time', 4);
        $this->service = $service;
        $this->serviceDuration = (new CarbonInterval(0))->createFromFormat('H:i', $this->service->duration);
        $this->carbon = $this->getCarbonForNextInterval();
        $this->maxCarbon = $this->carbon->copy()->addWeeks($this->weeks)->endOfDay();
        $this->minCarbonInterval = (new CarbonInterval(0))->addHours(config('booker.opening_hour', 8));
        $this->maxCarbonInterval = (new CarbonInterval(0))
            ->addHours(config('booker.ending_hour', 16))
            ->subMinutes($this->serviceDuration->totalMinutes)
            ->cascade();
        $this->employeeIds = !is_null($employee)
            ? [$employee->id]
            : $this->service->employees->pluck('id')->toArray();
        $this->reservations = Reservation::getReservations($this->employeeIds);
    }

    public function getAvailableSpots() : array
    {
        while ($this->carbon->lt($this->maxCarbon))
        {
            $availableEmployees = [];
            if (!$this->isIntervalAvailable($availableEmployees))
                continue;

            $availableSpots[$this->carbon->format('d-m-Y')][$this->carbon->format('H:i')] = $availableEmployees;
            $this->carbon->addMinutes($this->interval);
        }

        return $availableSpots ?? [];
    }

    private function getCarbonForNextInterval() : Carbon
    {
        if (!empty($this->carbon))
            return $this->carbon;

        $carbon = Carbon::now()->startOfMinute();
        $carbonMinutes = (int) $carbon->format('i');

        $interval = $this->interval;
        while ($interval < $carbonMinutes)
            $interval += $this->interval;

        $carbon->minutes($interval);

        return $carbon;
    }

    private function isIntervalAvailable(array &$availableEmployees) : bool
    {
        $carbonInterval = $this->carbon->diffAsCarbonInterval($this->carbon->copy()->startOfDay());

        if ($carbonInterval->lt($this->minCarbonInterval))
        {
            $this->carbon->setTime(0, $this->minCarbonInterval->totalMinutes);
            return false;
        }

        if ($carbonInterval->gt($this->maxCarbonInterval))
        {
            $this->carbon->addDay()->setTime(0, $this->minCarbonInterval->totalMinutes);
            return false;
        }

        foreach ($this->employeeIds as $employeeId)
        {
            $available = !$this->reservations->get($this->carbon->format('Y-m-d') . '.' . $employeeId)
                ?->contains(function (Reservation $reservation)
                {
                    $reservationStartIncDuration = $reservation->starts_at
                        ->copy()
                        ->subMinutes($this->serviceDuration->totalMinutes);

                    if (($this->carbon->gte($reservation->starts_at) && $this->carbon->lt($reservation->ends_at))
                        || ($this->carbon->gt($reservationStartIncDuration) && $this->carbon->lte($reservation->starts_at)))
                        return true;

                    return false;
                });

            if ($available)
                $availableEmployees[] = $employeeId;
        }

        if (count($availableEmployees) > 0)
            return true;

        $this->carbon->addMinutes($this->interval);
        return false;
    }
}
