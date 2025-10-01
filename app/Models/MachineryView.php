<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineryView extends Model
{

    protected $fillable = [
        'machinery_id',
        'user_agent',
        'ip',
    ];

    public function machinery(): BelongsTo
    {
        return $this->belongsTo(Machinery::class);
    }
}
