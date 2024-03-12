<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\ChargerType;
use Illuminate\Http\Request;
use App\Models\SubMerkVehicle;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SubMerkVehicleStoreRequest;
use App\Http\Requests\SubMerkVehicleUpdateRequest;

class SubMerkVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SubMerkVehicle::class);

        $search = $request->get('search', '');

        $subMerkVehicles = SubMerkVehicle::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.sub_merk_vehicles.index',
            compact('subMerkVehicles', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SubMerkVehicle::class);

        $typeVehicles = TypeVehicle::pluck('type', 'id');
        $merkVehicles = MerkVehicle::pluck('merk', 'id');
        $chargerTypes = ChargerType::pluck('name', 'id');

        return view(
            'app.sub_merk_vehicles.create',
            compact('typeVehicles', 'merkVehicles', 'chargerTypes')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubMerkVehicleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SubMerkVehicle::class);

        $validated = $request->validated();

        $subMerkVehicle = SubMerkVehicle::create($validated);

        return redirect()
            ->route('sub-merk-vehicles.edit', $subMerkVehicle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SubMerkVehicle $subMerkVehicle): View
    {
        $this->authorize('view', $subMerkVehicle);

        return view('app.sub_merk_vehicles.show', compact('subMerkVehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SubMerkVehicle $subMerkVehicle): View
    {
        $this->authorize('update', $subMerkVehicle);

        $typeVehicles = TypeVehicle::pluck('type', 'id');
        $merkVehicles = MerkVehicle::pluck('merk', 'id');
        $chargerTypes = ChargerType::pluck('name', 'id');

        return view(
            'app.sub_merk_vehicles.edit',
            compact(
                'subMerkVehicle',
                'typeVehicles',
                'merkVehicles',
                'chargerTypes'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SubMerkVehicleUpdateRequest $request,
        SubMerkVehicle $subMerkVehicle
    ): RedirectResponse {
        $this->authorize('update', $subMerkVehicle);

        $validated = $request->validated();

        $subMerkVehicle->update($validated);

        return redirect()
            ->route('sub-merk-vehicles.edit', $subMerkVehicle)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): RedirectResponse {
        $this->authorize('delete', $subMerkVehicle);

        $subMerkVehicle->delete();

        return redirect()
            ->route('sub-merk-vehicles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
