<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\ChargeCollection;

class VehicleChargesController extends Controller
{
    public function index(Request $request, Vehicle $vehicle): ChargeCollection
    {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $charges = $vehicle
            ->charges()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargeCollection($charges);
    }

    public function store(Request $request, Vehicle $vehicle): ChargeResource
    {
        $this->authorize('create', Charge::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'date' => ['required', 'date'],
            'battery_start_charging' => ['required', 'numeric'],
            'battery_finish_charging' => ['nullable', 'numeric'],
            'battery_finish_before' => ['required', 'numeric'],
            'km_now' => ['required', 'numeric'],
            'km_before' => ['required', 'numeric'],
            'parking' => ['nullable', 'numeric'],
            'kWh' => ['nullable', 'numeric'],
            'PPJ' => ['nullable', 'numeric'],
            'PPN' => ['nullable', 'numeric'],
            'admin_cost' => ['nullable', 'numeric'],
            'total_cost' => ['nullable', 'numeric'],
            'charger_location_id' => [
                'required',
                'exists:charger_locations,id',
            ],
            'charger_id' => ['required', 'exists:chargers,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $charge = $vehicle->charges()->create($validated);

        return new ChargeResource($charge);
    }
}
