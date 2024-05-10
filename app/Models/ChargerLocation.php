<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargerLocation extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'charger_locations';

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function chargers()
    {
        return $this->hasMany(Charger::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function detailTrips()
    {
        return $this->hasMany(DetailTrip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
