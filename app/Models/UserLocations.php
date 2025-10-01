<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserLocations extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'address',
        'address_latitude',
        'address_longitude',
        'city',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
