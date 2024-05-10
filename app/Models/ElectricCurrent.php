<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ElectricCurrent extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'electric_currents';

    public function chargers()
    {
        return $this->hasMany(Charger::class);
    }

    public function subMerkVehicles()
    {
        return $this->belongsToMany(SubMerkVehicle::class);
    }
}
