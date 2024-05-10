<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerLocationResource;
use App\Http\Resources\ChargerLocationCollection;

class CityChargerLocationsController extends Controller
{
    public function index(
        Request $request,
        City $city
    ): ChargerLocationCollection {
        $this->authorize('view', $city);

        $search = $request->get('search', '');

        $chargerLocations = $city
            ->chargerLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerLocationCollection($chargerLocations);
    }

    public function store(Request $request, City $city): ChargerLocationResource
    {
        $this->authorize('create', ChargerLocation::class);

        $validated = $request->validate([
            'image' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:100', 'string'],
            'provider_id' => ['required', 'exists:providers,id'],
            'location_on' => ['required', 'in:closed,dealer,private,public'],
            'system' => ['required', 'in:free,hour_base,kwh_base,parking_base'],
            'parking' => ['required', 'in:yes,no'],
            'coordinate' => ['nullable', 'max:100', 'string'],
            'maps' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'in:verified,not verified'],
            'description' => ['nullable', 'max:255', 'string'],
            'province_id' => ['required', 'exists:provinces,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation = $city->chargerLocations()->create($validated);

        return new ChargerLocationResource($chargerLocation);
    }
}
