<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function chargerLocation()
    {
        return $this->belongsTo(ChargerLocation::class);
    }

    public function charger()
    {
        return $this->belongsTo(Charger::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
