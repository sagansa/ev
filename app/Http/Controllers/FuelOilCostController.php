<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\View\View;
use App\Models\FuelOilCost;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FuelOilCostStoreRequest;
use App\Http\Requests\FuelOilCostUpdateRequest;

class FuelOilCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', FuelOilCost::class);

        $search = $request->get('search', '');

        $fuelOilCosts = FuelOilCost::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.fuel_oil_costs.index',
            compact('fuelOilCosts', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', FuelOilCost::class);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view('app.fuel_oil_costs.create', compact('vehicles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FuelOilCostStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', FuelOilCost::class);

        $validated = $request->validated();

        $fuelOilCost = FuelOilCost::create($validated);

        return redirect()
            ->route('fuel-oil-costs.edit', $fuelOilCost)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FuelOilCost $fuelOilCost): View
    {
        $this->authorize('view', $fuelOilCost);

        return view('app.fuel_oil_costs.show', compact('fuelOilCost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, FuelOilCost $fuelOilCost): View
    {
        $this->authorize('update', $fuelOilCost);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.fuel_oil_costs.edit',
            compact('fuelOilCost', 'vehicles', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FuelOilCostUpdateRequest $request,
        FuelOilCost $fuelOilCost
    ): RedirectResponse {
        $this->authorize('update', $fuelOilCost);

        $validated = $request->validated();

        $fuelOilCost->update($validated);

        return redirect()
            ->route('fuel-oil-costs.edit', $fuelOilCost)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        FuelOilCost $fuelOilCost
    ): RedirectResponse {
        $this->authorize('delete', $fuelOilCost);

        $fuelOilCost->delete();

        return redirect()
            ->route('fuel-oil-costs.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
