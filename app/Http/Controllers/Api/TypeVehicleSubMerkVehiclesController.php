<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubMerkVehicleResource;
use App\Http\Resources\SubMerkVehicleCollection;

class TypeVehicleSubMerkVehiclesController extends Controller
{
    public function index(
        Request $request,
        TypeVehicle $typeVehicle
    ): SubMerkVehicleCollection {
        $this->authorize('view', $typeVehicle);

        $search = $request->get('search', '');

        $subMerkVehicles = $typeVehicle
            ->subMerkVehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubMerkVehicleCollection($subMerkVehicles);
    }

    public function store(
        Request $request,
        TypeVehicle $typeVehicle
    ): SubMerkVehicleResource {
        $this->authorize('create', SubMerkVehicle::class);

        $validated = $request->validate([
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
            'sub_merk' => [
                'required',
                'unique:sub_merk_vehicles,sub_merk',
                'max:30',
                'string',
            ],
            'battery_capacity' => ['required', 'numeric'],
            'charger_type_id' => ['required', 'exists:charger_types,id'],
        ]);

        $subMerkVehicle = $typeVehicle->subMerkVehicles()->create($validated);

        return new SubMerkVehicleResource($subMerkVehicle);
    }
}
