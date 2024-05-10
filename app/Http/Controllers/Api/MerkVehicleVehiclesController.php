<?php

namespace App\Http\Controllers\Api;

use App\Models\MerkVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class MerkVehicleVehiclesController extends Controller
{
    public function index(
        Request $request,
        MerkVehicle $merkVehicle
    ): VehicleCollection {
        $this->authorize('view', $merkVehicle);

        $search = $request->get('search', '');

        $vehicles = $merkVehicle
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    public function store(
        Request $request,
        MerkVehicle $merkVehicle
    ): VehicleResource {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'license_plate' => ['required', 'max:10', 'string'],
            'ownership' => ['required', 'date'],
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
            'sub_merk_vehicle_id' => [
                'required',
                'exists:sub_merk_vehicles,id',
            ],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = $merkVehicle->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
