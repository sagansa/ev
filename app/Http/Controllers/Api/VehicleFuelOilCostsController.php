<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelOilCostResource;
use App\Http\Resources\FuelOilCostCollection;

class VehicleFuelOilCostsController extends Controller
{
    public function index(
        Request $request,
        Vehicle $vehicle
    ): FuelOilCostCollection {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $fuelOilCosts = $vehicle
            ->fuelOilCosts()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelOilCostCollection($fuelOilCosts);
    }

    public function store(
        Request $request,
        Vehicle $vehicle
    ): FuelOilCostResource {
        $this->authorize('create', FuelOilCost::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'fuel_price' => ['required', 'numeric'],
            'km_start' => ['required', 'numeric'],
            'km_end' => ['nullable', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $fuelOilCost = $vehicle->fuelOilCosts()->create($validated);

        return new FuelOilCostResource($fuelOilCost);
    }
}
