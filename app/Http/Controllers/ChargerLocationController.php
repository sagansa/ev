<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use App\Models\Provider;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChargerLocationStoreRequest;
use App\Http\Requests\ChargerLocationUpdateRequest;

class ChargerLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ChargerLocation::class);

        $search = $request->get('search', '');

        $chargerLocations = ChargerLocation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.charger_locations.index',
            compact('chargerLocations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ChargerLocation::class);

        $providers = Provider::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $provinces = Province::pluck('province', 'id');
        $cities = City::pluck('city', 'id');

        return view(
            'app.charger_locations.create',
            compact('providers', 'users', 'provinces', 'cities')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ChargerLocationStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ChargerLocation::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation = ChargerLocation::create($validated);

        return redirect()
            ->route('charger-locations.edit', $chargerLocation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ChargerLocation $chargerLocation
    ): View {
        $this->authorize('view', $chargerLocation);

        return view('app.charger_locations.show', compact('chargerLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ChargerLocation $chargerLocation
    ): View {
        $this->authorize('update', $chargerLocation);

        $providers = Provider::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $provinces = Province::pluck('province', 'id');
        $cities = City::pluck('city', 'id');

        return view(
            'app.charger_locations.edit',
            compact(
                'chargerLocation',
                'providers',
                'users',
                'provinces',
                'cities'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ChargerLocationUpdateRequest $request,
        ChargerLocation $chargerLocation
    ): RedirectResponse {
        $this->authorize('update', $chargerLocation);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($chargerLocation->image) {
                Storage::delete($chargerLocation->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation->update($validated);

        return redirect()
            ->route('charger-locations.edit', $chargerLocation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ChargerLocation $chargerLocation
    ): RedirectResponse {
        $this->authorize('delete', $chargerLocation);

        if ($chargerLocation->image) {
            Storage::delete($chargerLocation->image);
        }

        $chargerLocation->delete();

        return redirect()
            ->route('charger-locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
