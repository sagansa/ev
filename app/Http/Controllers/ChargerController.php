<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Charger;
use Illuminate\View\View;
use App\Models\ChargerType;
use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use App\Models\ElectricCurrent;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ChargerStoreRequest;
use App\Http\Requests\ChargerUpdateRequest;

class ChargerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Charger::class);

        $search = $request->get('search', '');

        $chargers = Charger::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.chargers.index', compact('chargers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Charger::class);

        $chargerLocations = ChargerLocation::pluck('name', 'id');
        $chargerTypes = ChargerType::pluck('name', 'id');
        $electricCurrents = ElectricCurrent::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.chargers.create',
            compact(
                'chargerLocations',
                'chargerTypes',
                'electricCurrents',
                'users'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChargerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Charger::class);

        $validated = $request->validated();

        $charger = Charger::create($validated);

        return redirect()
            ->route('chargers.edit', $charger)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Charger $charger): View
    {
        $this->authorize('view', $charger);

        return view('app.chargers.show', compact('charger'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Charger $charger): View
    {
        $this->authorize('update', $charger);

        $chargerLocations = ChargerLocation::pluck('name', 'id');
        $chargerTypes = ChargerType::pluck('name', 'id');
        $electricCurrents = ElectricCurrent::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.chargers.edit',
            compact(
                'charger',
                'chargerLocations',
                'chargerTypes',
                'electricCurrents',
                'users'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ChargerUpdateRequest $request,
        Charger $charger
    ): RedirectResponse {
        $this->authorize('update', $charger);

        $validated = $request->validated();

        $charger->update($validated);

        return redirect()
            ->route('chargers.edit', $charger)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Charger $charger
    ): RedirectResponse {
        $this->authorize('delete', $charger);

        $charger->delete();

        return redirect()
            ->route('chargers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
