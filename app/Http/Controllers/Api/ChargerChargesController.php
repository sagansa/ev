<?php

namespace App\Http\Controllers\Api;

use App\Models\Charger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\ChargeCollection;

class ChargerChargesController extends Controller
{
    public function index(Request $request, Charger $charger): ChargeCollection
    {
        $this->authorize('view', $charger);

        $search = $request->get('search', '');

        $charges = $charger
            ->charges()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargeCollection($charges);
    }

    public function store(Request $request, Charger $charger): ChargeResource
    {
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
            'charger_location_id' => [
                'required',
                'exists:charger_locations,id',
            ],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $charge = $charger->charges()->create($validated);

        return new ChargeResource($charge);
    }
}
