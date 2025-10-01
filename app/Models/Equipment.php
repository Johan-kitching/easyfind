<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Equipment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'codes_and_descriptions_id',
        'user_id',
        'operator_id',
        'description',
        'address',
        'city',
        'address_latitude',
        'address_longitude',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function codesAndDescriptions(): HasOne
    {
        return $this->hasOne(codes_and_descriptions::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function operator(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'parental');
    }
}
