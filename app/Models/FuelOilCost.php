<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FuelOilCost extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'vehicle_id',
        'date',
        'fuel_price',
        'km_start',
        'km_end',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fuel_oil_costs';

    protected $casts = [
        'date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
