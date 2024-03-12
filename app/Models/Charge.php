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

    protected $fillable = [
        'vehicle_id',
        'date',
        'charger_location_id',
        'charger_id',
        'km_now',
        'km_before',
        'battery_start_charging',
        'battery_finish_charging',
        'battery_finish_before',
        'parking',
        'kWh',
        'PPJ',
        'PPN',
        'admin_cost',
        'total_cost',
        'image',
        'user_id',
    ];

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
