<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TypeVehicleStoreRequest;
use App\Http\Requests\TypeVehicleUpdateRequest;

class TypeVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', TypeVehicle::class);

        $search = $request->get('search', '');

        $typeVehicles = TypeVehicle::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.type_vehicles.index',
            compact('typeVehicles', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', TypeVehicle::class);

        return view('app.type_vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeVehicleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', TypeVehicle::class);

        $validated = $request->validated();

        $typeVehicle = TypeVehicle::create($validated);

        return redirect()
            ->route('type-vehicles.edit', $typeVehicle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TypeVehicle $typeVehicle): View
    {
        $this->authorize('view', $typeVehicle);

        return view('app.type_vehicles.show', compact('typeVehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, TypeVehicle $typeVehicle): View
    {
        $this->authorize('update', $typeVehicle);

        return view('app.type_vehicles.edit', compact('typeVehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TypeVehicleUpdateRequest $request,
        TypeVehicle $typeVehicle
    ): RedirectResponse {
        $this->authorize('update', $typeVehicle);

        $validated = $request->validated();

        $typeVehicle->update($validated);

        return redirect()
            ->route('type-vehicles.edit', $typeVehicle)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        TypeVehicle $typeVehicle
    ): RedirectResponse {
        $this->authorize('delete', $typeVehicle);

        $typeVehicle->delete();

        return redirect()
            ->route('type-vehicles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
