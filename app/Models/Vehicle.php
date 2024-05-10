<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $casts = [
        'ownership' => 'date',
    ];

    public function typeVehicle()
    {
        return $this->belongsTo(TypeVehicle::class);
    }

    public function merkVehicle()
    {
        return $this->belongsTo(MerkVehicle::class);
    }

    public function subMerkVehicle()
    {
        return $this->belongsTo(SubMerkVehicle::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function fuelOilCosts()
    {
        return $this->hasMany(FuelOilCost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stateOfHealths()
    {
        return $this->hasMany(StateOfHealth::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
