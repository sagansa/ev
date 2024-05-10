<?php

namespace App\Http\Controllers\Api;

use App\Models\ChargerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubMerkVehicleResource;
use App\Http\Resources\SubMerkVehicleCollection;

class ChargerTypeSubMerkVehiclesController extends Controller
{
    public function index(
        Request $request,
        ChargerType $chargerType
    ): SubMerkVehicleCollection {
        $this->authorize('view', $chargerType);

        $search = $request->get('search', '');

        $subMerkVehicles = $chargerType
            ->subMerkVehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubMerkVehicleCollection($subMerkVehicles);
    }

    public function store(
        Request $request,
        ChargerType $chargerType
    ): SubMerkVehicleResource {
        $this->authorize('create', SubMerkVehicle::class);

        $validated = $request->validate([
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
            'sub_merk' => [
                'required',
                'unique:sub_merk_vehicles,sub_merk',
                'max:30',
                'string',
            ],
            'battery_capacity' => ['required', 'numeric'],
        ]);

        $subMerkVehicle = $chargerType->subMerkVehicles()->create($validated);

        return new SubMerkVehicleResource($subMerkVehicle);
    }
}
