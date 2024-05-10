<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelOilCostResource;
use App\Http\Resources\FuelOilCostCollection;

class UserFuelOilCostsController extends Controller
{
    public function index(Request $request, User $user): FuelOilCostCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $fuelOilCosts = $user
            ->fuelOilCosts()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelOilCostCollection($fuelOilCosts);
    }

    public function store(Request $request, User $user): FuelOilCostResource
    {
        $this->authorize('create', FuelOilCost::class);

        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'date' => ['required', 'date'],
            'fuel_price' => ['required', 'numeric'],
            'km_start' => ['required', 'numeric'],
            'km_end' => ['nullable', 'numeric'],
        ]);

        $fuelOilCost = $user->fuelOilCosts()->create($validated);

        return new FuelOilCostResource($fuelOilCost);
    }
}
