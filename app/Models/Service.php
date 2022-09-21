<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
}
