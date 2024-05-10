<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubMerkVehicle extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'sub_merk_vehicles';

    public function typeVehicle()
    {
        return $this->belongsTo(TypeVehicle::class);
    }

    public function merkVehicle()
    {
        return $this->belongsTo(MerkVehicle::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function chargerType()
    {
        return $this->belongsTo(ChargerType::class);
    }

    public function electricCurrents()
    {
        return $this->belongsToMany(ElectricCurrent::class);
    }
}
