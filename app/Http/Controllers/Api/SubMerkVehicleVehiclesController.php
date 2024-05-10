<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SubMerkVehicle;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class SubMerkVehicleVehiclesController extends Controller
{
    public function index(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): VehicleCollection {
        $this->authorize('view', $subMerkVehicle);

        $search = $request->get('search', '');

        $vehicles = $subMerkVehicle
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    public function store(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): VehicleResource {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'license_plate' => ['required', 'max:10', 'string'],
            'ownership' => ['required', 'date'],
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = $subMerkVehicle->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
