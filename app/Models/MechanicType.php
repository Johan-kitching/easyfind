<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MechanicType extends Model
{
    use SoftDeletes;

    protected $table = 'mechanic_type';

    protected $fillable = [
        'name',
    ];

    public function mechanics(): HasMany
    {
        return $this->hasMany(Mechanic::class);
    }
}
