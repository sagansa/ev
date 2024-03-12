<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['city', 'province_id'];

    protected $searchableFields = ['*'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function chargerLocations()
    {
        return $this->hasMany(ChargerLocation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
