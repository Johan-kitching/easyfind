<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransporterType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function transporters():HasMany
    {
        return $this->hasMany(Transporter::class, 'transporter_type_id', 'id');
    }
}
