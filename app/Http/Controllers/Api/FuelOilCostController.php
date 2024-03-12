<?php

namespace App\Http\Controllers\Api;

use App\Models\FuelOilCost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelOilCostResource;
use App\Http\Resources\FuelOilCostCollection;
use App\Http\Requests\FuelOilCostStoreRequest;
use App\Http\Requests\FuelOilCostUpdateRequest;

class FuelOilCostController extends Controller
{
    public function index(Request $request): FuelOilCostCollection
    {
        $this->authorize('view-any', FuelOilCost::class);

        $search = $request->get('search', '');

        $fuelOilCosts = FuelOilCost::search($search)
            ->latest()
            ->paginate();

        return new FuelOilCostCollection($fuelOilCosts);
    }

    public function store(FuelOilCostStoreRequest $request): FuelOilCostResource
    {
        $this->authorize('create', FuelOilCost::class);

        $validated = $request->validated();

        $fuelOilCost = FuelOilCost::create($validated);

        return new FuelOilCostResource($fuelOilCost);
    }

    public function show(
        Request $request,
        FuelOilCost $fuelOilCost
    ): FuelOilCostResource {
        $this->authorize('view', $fuelOilCost);

        return new FuelOilCostResource($fuelOilCost);
    }

    public function update(
        FuelOilCostUpdateRequest $request,
        FuelOilCost $fuelOilCost
    ): FuelOilCostResource {
        $this->authorize('update', $fuelOilCost);

        $validated = $request->validated();

        $fuelOilCost->update($validated);

        return new FuelOilCostResource($fuelOilCost);
    }

    public function destroy(
        Request $request,
        FuelOilCost $fuelOilCost
    ): Response {
        $this->authorize('delete', $fuelOilCost);

        $fuelOilCost->delete();

        return response()->noContent();
    }
}
