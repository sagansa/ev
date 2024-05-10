<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerkVehicle extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'merk_vehicles';

    public function subMerkVehicles()
    {
        return $this->hasMany(SubMerkVehicle::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function typeVehicle()
    {
        return $this->belongsTo(TypeVehicle::class);
    }
}
