<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuids;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $guarded = [
        'email_verified_at',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'current_team_id',
        'profile_photo_path',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    public function stateOfHealths()
    {
        return $this->hasMany(StateOfHealth::class);
    }

    public function fuelOilCosts()
    {
        return $this->hasMany(FuelOilCost::class);
    }

    public function chargers()
    {
        return $this->hasMany(Charger::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function chargerLocations()
    {
        return $this->hasMany(ChargerLocation::class);
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->email, config('auth.super_admins'));
    }
}
