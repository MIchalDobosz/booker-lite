<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public static function getList(): array
    {
        return self::query()
            ->selectRaw('id, concat(first_name, " ", last_name) as name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
