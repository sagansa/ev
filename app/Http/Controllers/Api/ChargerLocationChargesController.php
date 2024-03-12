<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\ChargeCollection;

class ChargerLocationChargesController extends Controller
{
    public function index(
        Request $request,
        ChargerLocation $chargerLocation
    ): ChargeCollection {
        $this->authorize('view', $chargerLocation);

        $search = $request->get('search', '');

        $charges = $chargerLocation
            ->charges()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargeCollection($charges);
    }

    public function store(
        Request $request,
        ChargerLocation $chargerLocation
    ): ChargeResource {
        $this->authorize('create', Charge::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
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
            'charger_id' => ['required', 'exists:chargers,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $charge = $chargerLocation->charges()->create($validated);

        return new ChargeResource($charge);
    }
}
