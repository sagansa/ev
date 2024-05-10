<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class TypeVehicleVehiclesController extends Controller
{
    public function index(
        Request $request,
        TypeVehicle $typeVehicle
    ): VehicleCollection {
        $this->authorize('view', $typeVehicle);

        $search = $request->get('search', '');

        $vehicles = $typeVehicle
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    public function store(
        Request $request,
        TypeVehicle $typeVehicle
    ): VehicleResource {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'license_plate' => ['required', 'max:10', 'string'],
            'ownership' => ['required', 'date'],
            'user_id' => ['required', 'exists:users,id'],
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
            'sub_merk_vehicle_id' => [
                'required',
                'exists:sub_merk_vehicles,id',
            ],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = $typeVehicle->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
