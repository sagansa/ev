<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\StateOfHealth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StateOfHealthStoreRequest;
use App\Http\Requests\StateOfHealthUpdateRequest;

class StateOfHealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', StateOfHealth::class);

        $search = $request->get('search', '');

        $stateOfHealths = StateOfHealth::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.state_of_healths.index',
            compact('stateOfHealths', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', StateOfHealth::class);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.state_of_healths.create',
            compact('vehicles', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateOfHealthStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', StateOfHealth::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth = StateOfHealth::create($validated);

        return redirect()
            ->route('state-of-healths.edit', $stateOfHealth)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, StateOfHealth $stateOfHealth): View
    {
        $this->authorize('view', $stateOfHealth);

        return view('app.state_of_healths.show', compact('stateOfHealth'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, StateOfHealth $stateOfHealth): View
    {
        $this->authorize('update', $stateOfHealth);

        $vehicles = Vehicle::pluck('image', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.state_of_healths.edit',
            compact('stateOfHealth', 'vehicles', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StateOfHealthUpdateRequest $request,
        StateOfHealth $stateOfHealth
    ): RedirectResponse {
        $this->authorize('update', $stateOfHealth);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($stateOfHealth->image) {
                Storage::delete($stateOfHealth->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth->update($validated);

        return redirect()
            ->route('state-of-healths.edit', $stateOfHealth)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        StateOfHealth $stateOfHealth
    ): RedirectResponse {
        $this->authorize('delete', $stateOfHealth);

        if ($stateOfHealth->image) {
            Storage::delete($stateOfHealth->image);
        }

        $stateOfHealth->delete();

        return redirect()
            ->route('state-of-healths.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
