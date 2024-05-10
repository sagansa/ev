<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    public function cities()
    {
        return $this->hasMany(City::class);
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
