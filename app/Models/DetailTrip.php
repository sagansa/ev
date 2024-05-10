<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTrip extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'detail_trips';

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function chargerLocation()
    {
        return $this->belongsTo(ChargerLocation::class);
    }
}
