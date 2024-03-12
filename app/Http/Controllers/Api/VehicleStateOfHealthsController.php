<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StateOfHealthResource;
use App\Http\Resources\StateOfHealthCollection;

class VehicleStateOfHealthsController extends Controller
{
    public function index(
        Request $request,
        Vehicle $vehicle
    ): StateOfHealthCollection {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $stateOfHealths = $vehicle
            ->stateOfHealths()
            ->search($search)
            ->latest()
            ->paginate();

        return new StateOfHealthCollection($stateOfHealths);
    }

    public function store(
        Request $request,
        Vehicle $vehicle
    ): StateOfHealthResource {
        $this->authorize('create', StateOfHealth::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'km' => ['required', 'numeric'],
            'percentage' => ['required', 'numeric'],
            'how_to_charge' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'in:not verified,verified'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth = $vehicle->stateOfHealths()->create($validated);

        return new StateOfHealthResource($stateOfHealth);
    }
}
