<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Charge;
use App\Models\Vehicle;
use App\Models\Charger;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChargeStoreRequest;
use App\Http\Requests\ChargeUpdateRequest;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Charge::class);

        $search = $request->get('search', '');

        $charges = Charge::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.charges.index', compact('charges', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Charge::class);

        $vehicles = Vehicle::pluck('image', 'id');
        $chargerLocations = ChargerLocation::pluck('name', 'id');
        $chargers = Charger::pluck('power', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.charges.create',
            compact('vehicles', 'chargerLocations', 'chargers', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChargeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Charge::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $charge = Charge::create($validated);

        return redirect()
            ->route('charges.edit', $charge)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Charge $charge): View
    {
        $this->authorize('view', $charge);

        return view('app.charges.show', compact('charge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Charge $charge): View
    {
        $this->authorize('update', $charge);

        $vehicles = Vehicle::pluck('image', 'id');
        $chargerLocations = ChargerLocation::pluck('name', 'id');
        $chargers = Charger::pluck('power', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.charges.edit',
            compact(
                'charge',
                'vehicles',
                'chargerLocations',
                'chargers',
                'users'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ChargeUpdateRequest $request,
        Charge $charge
    ): RedirectResponse {
        $this->authorize('update', $charge);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($charge->image) {
                Storage::delete($charge->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $charge->update($validated);

        return redirect()
            ->route('charges.edit', $charge)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Charge $charge): RedirectResponse
    {
        $this->authorize('delete', $charge);

        if ($charge->image) {
            Storage::delete($charge->image);
        }

        $charge->delete();

        return redirect()
            ->route('charges.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
