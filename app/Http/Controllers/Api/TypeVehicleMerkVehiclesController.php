<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MerkVehicleResource;
use App\Http\Resources\MerkVehicleCollection;

class TypeVehicleMerkVehiclesController extends Controller
{
    public function index(
        Request $request,
        TypeVehicle $typeVehicle
    ): MerkVehicleCollection {
        $this->authorize('view', $typeVehicle);

        $search = $request->get('search', '');

        $merkVehicles = $typeVehicle
            ->merkVehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new MerkVehicleCollection($merkVehicles);
    }

    public function store(
        Request $request,
        TypeVehicle $typeVehicle
    ): MerkVehicleResource {
        $this->authorize('create', MerkVehicle::class);

        $validated = $request->validate([
            'merk' => [
                'required',
                'unique:merk_vehicles,merk',
                'max:20',
                'string',
            ],
        ]);

        $merkVehicle = $typeVehicle->merkVehicles()->create($validated);

        return new MerkVehicleResource($merkVehicle);
    }
}
