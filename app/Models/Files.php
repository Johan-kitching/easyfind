<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Files extends Model
{

    use LogsActivity;

    public $fillable = ['path', 'filename', 'file_type', 'directory', 'parental_type', 'parental_id'];
    protected $appends = ['full_path'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function parental(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFullPathAttribute(): ?string
    {
        return match (true) {
            $this->file_type == "machinery" && $this->parental_type == "App\Models\Machinery" => '/storage/app/machinery/' . $this->parental_id . '/photos/' . $this->path,
            $this->file_type == "equipment" && $this->parental_type == "App\Models\Equipment" => '/storage/app/equipment/' . $this->parental_id . '/photos/' . $this->path,
            $this->file_type == "transporter" && $this->parental_type == "App\Models\Transporter" => '/storage/app/transporter/' . $this->parental_id . '/photos/' . $this->path,
            default => null,
        };
    }
}
