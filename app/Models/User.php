<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected function getDefaultGuardName(): string
    {
        return 'web';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'memberName',
        'name',
        'number',
        'companyName',
        'companyContact',
        'companyNumber',
        'website',
        'address',
        'email',
        'password',
        'terms',
        'type',
        'status',
        'current_team_id',
        'package_id',
        'pf_token',
        'pf_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return empty($this->name) ? $this->name : $this->companyName;
    }

    public function address(): HasMany
    {
        return $this->hasMany(UserLocations::class);
    }

    public function currentTeam(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function currentTeamMembers(): HasMany
    {
        return $this->hasMany(User::class, 'current_team_id', 'id');
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'operator_id', 'id');
    }

    public function machinery()
    {
        if ($this->current_team_id) {
            return $this->hasMany(Machinery::class, 'operator_id', 'id')->where('user_id', $this->current_team_id);
        }
        return $this->hasMany(Machinery::class, 'user_id', 'id');
    }

    public function mechanics(): HasMany
    {
        return $this->hasMany(Mechanic::class, 'user_id', 'id');
    }

    public function transporters(): HasMany
    {
        return $this->hasMany(Transporter::class, 'user_id', 'id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(UserPayment::class, 'user_id', 'id');
    }

    public function package(): HasOne
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    public function getCanAddAssetsAttribute(): bool
    {
        $count = $this->machinery()->count() + $this->transporters()->count() + $this->mechanics()->count();
        return $count < $this->package?->assets && $this->payments()->where('created_at', '>', now()->subDays(30))->count() >= 1;
    }

    public function getMyAssetsCountAttribute(): int
    {
        return ($this->machinery->count() + $this->transporters->count() + $this->mechanics->count());
    }

    public function getAssetsRemainingAttribute(): int
    {
        $count = $this->machinery()->count() + $this->transporters()->count() + $this->mechanics()->count();
        if ($this->getHasActiveSubscriptionAttribute()) {
            return ($this->package->assets - $count);
        } else {
            return 0;
        }
    }

    public function getHasActiveSubscriptionAttribute(): bool
    {
        return $this->payments()->where('created_at', '>', now()->subMonth())->count() >= 1;
    }

}
