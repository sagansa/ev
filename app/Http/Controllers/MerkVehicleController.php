<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\MerkVehicle;
use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MerkVehicleStoreRequest;
use App\Http\Requests\MerkVehicleUpdateRequest;

class MerkVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', MerkVehicle::class);

        $search = $request->get('search', '');

        $merkVehicles = MerkVehicle::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.merk_vehicles.index',
            compact('merkVehicles', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', MerkVehicle::class);

        $typeVehicles = TypeVehicle::pluck('type', 'id');

        return view('app.merk_vehicles.create', compact('typeVehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MerkVehicleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', MerkVehicle::class);

        $validated = $request->validated();

        $merkVehicle = MerkVehicle::create($validated);

        return redirect()
            ->route('merk-vehicles.edit', $merkVehicle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, MerkVehicle $merkVehicle): View
    {
        $this->authorize('view', $merkVehicle);

        return view('app.merk_vehicles.show', compact('merkVehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, MerkVehicle $merkVehicle): View
    {
        $this->authorize('update', $merkVehicle);

        $typeVehicles = TypeVehicle::pluck('type', 'id');

        return view(
            'app.merk_vehicles.edit',
            compact('merkVehicle', 'typeVehicles')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        MerkVehicleUpdateRequest $request,
        MerkVehicle $merkVehicle
    ): RedirectResponse {
        $this->authorize('update', $merkVehicle);

        $validated = $request->validated();

        $merkVehicle->update($validated);

        return redirect()
            ->route('merk-vehicles.edit', $merkVehicle)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        MerkVehicle $merkVehicle
    ): RedirectResponse {
        $this->authorize('delete', $merkVehicle);

        $merkVehicle->delete();

        return redirect()
            ->route('merk-vehicles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
