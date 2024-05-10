<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charger extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    public function chargerLocation()
    {
        return $this->belongsTo(ChargerLocation::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function chargerType()
    {
        return $this->belongsTo(ChargerType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function electricCurrent()
    {
        return $this->belongsTo(ElectricCurrent::class);
    }
}
