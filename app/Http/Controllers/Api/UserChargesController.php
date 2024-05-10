<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\ChargeCollection;

class UserChargesController extends Controller
{
    public function index(Request $request, User $user): ChargeCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $charges = $user
            ->charges()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargeCollection($charges);
    }

    public function store(Request $request, User $user): ChargeResource
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
            'charger_id' => ['required', 'exists:chargers,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $charge = $user->charges()->create($validated);

        return new ChargeResource($charge);
    }
}
