<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservations() : HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function duration() : Attribute
    {
        return Attribute::make(
            fn ($value) => CarbonInterval::createFromFormat('H:i:s', $value)->format('%H:%I')
        );
    }

    public function price() : Attribute
    {
        return Attribute::make(
            fn ($value) => number_format((float) $value / 100, 2),
            fn ($value) => !is_int($value) ? (int) ($value * 100) : $value
        );
    }

    public function getDurationInMinutes() : int
    {
        return (int) CarbonInterval::createFromFormat('H:i', $this->duration)->totalMinutes;
    }

    public static function getList() : array
    {
        return self::pluck('name', 'id')->toArray();
    }
}
