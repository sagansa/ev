<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerLocationResource;
use App\Http\Resources\ChargerLocationCollection;

class ProvinceChargerLocationsController extends Controller
{
    public function index(
        Request $request,
        Province $province
    ): ChargerLocationCollection {
        $this->authorize('view', $province);

        $search = $request->get('search', '');

        $chargerLocations = $province
            ->chargerLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerLocationCollection($chargerLocations);
    }

    public function store(
        Request $request,
        Province $province
    ): ChargerLocationResource {
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
            'city_id' => ['required', 'exists:cities,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation = $province->chargerLocations()->create($validated);

        return new ChargerLocationResource($chargerLocation);
    }
}
