<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Machinery extends Model
{
    use SoftDeletes, LogsActivity;


    protected $fillable = [
        'machinery_type_id',
        'user_id',
        'operator_id',
        'description',
        'address',
        'city',
        'address_latitude',
        'address_longitude',
    ];
    protected $with = ['type', 'user', 'operator', 'photos'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function type(): HasOne
    {
        return $this->hasOne(MachineryType::class, 'id', 'machinery_type_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function operator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'operator_id');
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Files::class, 'parental', 'parental_type', 'parental_id', 'id');
    }

    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'parental');
    }

    public function views(): HasMany
    {
        return $this->hasMany(MachineryView::class, 'machinery_id', 'id');
    }
}
