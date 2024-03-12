<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'from',
        'coordinate_from',
        'to',
        'coordinate_to',
    ];

    protected $searchableFields = ['*'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTrips()
    {
        return $this->hasMany(DetailTrip::class);
    }
}
