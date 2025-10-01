<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mechanic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'mechanic_type_id',
        'address',
        'city',
        'address_latitude',
        'address_longitude',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MechanicType::class, 'mechanic_type_id', 'id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(MechanicView::class, 'mechanic_id', 'id');
    }

    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'parental');
    }
}
