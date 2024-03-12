<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ChargerType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ChargerTypeStoreRequest;
use App\Http\Requests\ChargerTypeUpdateRequest;

class ChargerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ChargerType::class);

        $search = $request->get('search', '');

        $chargerTypes = ChargerType::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.charger_types.index',
            compact('chargerTypes', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ChargerType::class);

        return view('app.charger_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChargerTypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ChargerType::class);

        $validated = $request->validated();

        $chargerType = ChargerType::create($validated);

        return redirect()
            ->route('charger-types.edit', $chargerType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ChargerType $chargerType): View
    {
        $this->authorize('view', $chargerType);

        return view('app.charger_types.show', compact('chargerType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ChargerType $chargerType): View
    {
        $this->authorize('update', $chargerType);

        return view('app.charger_types.edit', compact('chargerType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ChargerTypeUpdateRequest $request,
        ChargerType $chargerType
    ): RedirectResponse {
        $this->authorize('update', $chargerType);

        $validated = $request->validated();

        $chargerType->update($validated);

        return redirect()
            ->route('charger-types.edit', $chargerType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ChargerType $chargerType
    ): RedirectResponse {
        $this->authorize('delete', $chargerType);

        $chargerType->delete();

        return redirect()
            ->route('charger-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
