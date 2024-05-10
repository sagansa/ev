<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;

class ProvinceCitiesController extends Controller
{
    public function index(Request $request, Province $province): CityCollection
    {
        $this->authorize('view', $province);

        $search = $request->get('search', '');

        $cities = $province
            ->cities()
            ->search($search)
            ->latest()
            ->paginate();

        return new CityCollection($cities);
    }

    public function store(Request $request, Province $province): CityResource
    {
        $this->authorize('create', City::class);

        $validated = $request->validate([
            'city' => ['required', 'max:255', 'string'],
        ]);

        $city = $province->cities()->create($validated);

        return new CityResource($city);
    }
}
