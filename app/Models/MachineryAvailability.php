<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MachineryAvailability extends Model
{
    use SoftDeletes, logsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }


    protected $fillable = [
        'machinery_id',
        'start_date',
        'end_date',
    ];

    public function machinery(): BelongsTo
    {
        return $this->belongsTo(Machinery::class, 'Machinery');
    }
}
