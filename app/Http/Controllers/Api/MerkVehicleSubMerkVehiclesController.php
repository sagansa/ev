<?php

namespace App\Http\Controllers\Api;

use App\Models\MerkVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubMerkVehicleResource;
use App\Http\Resources\SubMerkVehicleCollection;

class MerkVehicleSubMerkVehiclesController extends Controller
{
    public function index(
        Request $request,
        MerkVehicle $merkVehicle
    ): SubMerkVehicleCollection {
        $this->authorize('view', $merkVehicle);

        $search = $request->get('search', '');

        $subMerkVehicles = $merkVehicle
            ->subMerkVehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubMerkVehicleCollection($subMerkVehicles);
    }

    public function store(
        Request $request,
        MerkVehicle $merkVehicle
    ): SubMerkVehicleResource {
        $this->authorize('create', SubMerkVehicle::class);

        $validated = $request->validate([
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'sub_merk' => [
                'required',
                'unique:sub_merk_vehicles,sub_merk',
                'max:30',
                'string',
            ],
            'battery_capacity' => ['required', 'numeric'],
            'charger_type_id' => ['required', 'exists:charger_types,id'],
        ]);

        $subMerkVehicle = $merkVehicle->subMerkVehicles()->create($validated);

        return new SubMerkVehicleResource($subMerkVehicle);
    }
}
