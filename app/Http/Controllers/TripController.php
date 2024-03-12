<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TripStoreRequest;
use App\Http\Requests\TripUpdateRequest;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Trip::class);

        $search = $request->get('search', '');

        $trips = Trip::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.trips.index', compact('trips', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Trip::class);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view('app.trips.create', compact('vehicles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TripStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validated();

        $trip = Trip::create($validated);

        return redirect()
            ->route('trips.edit', $trip)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Trip $trip): View
    {
        $this->authorize('view', $trip);

        return view('app.trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Trip $trip): View
    {
        $this->authorize('update', $trip);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view('app.trips.edit', compact('trip', 'vehicles', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TripUpdateRequest $request,
        Trip $trip
    ): RedirectResponse {
        $this->authorize('update', $trip);

        $validated = $request->validated();

        $trip->update($validated);

        return redirect()
            ->route('trips.edit', $trip)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Trip $trip): RedirectResponse
    {
        $this->authorize('delete', $trip);

        $trip->delete();

        return redirect()
            ->route('trips.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
