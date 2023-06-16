<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function serializeDate(DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public static function getReservations(array $employeeIds) : Collection
    {
        return self::query()
            ->select(['starts_at', 'ends_at', 'employee_id'])
            ->where('starts_at', '>', now())
            ->whereIn('employee_id', $employeeIds)
            ->get()
            ->groupBy(function (Reservation $reservation)
            {
                return $reservation->starts_at->format('Y-m-d') . '.' . $reservation->employee_id;
            });
    }
}
