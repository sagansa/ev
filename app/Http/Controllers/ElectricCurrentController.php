<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ElectricCurrent;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ElectricCurrentStoreRequest;
use App\Http\Requests\ElectricCurrentUpdateRequest;

class ElectricCurrentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ElectricCurrent::class);

        $search = $request->get('search', '');

        $electricCurrents = ElectricCurrent::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.electric_currents.index',
            compact('electricCurrents', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ElectricCurrent::class);

        return view('app.electric_currents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ElectricCurrentStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ElectricCurrent::class);

        $validated = $request->validated();

        $electricCurrent = ElectricCurrent::create($validated);

        return redirect()
            ->route('electric-currents.edit', $electricCurrent)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ElectricCurrent $electricCurrent
    ): View {
        $this->authorize('view', $electricCurrent);

        return view('app.electric_currents.show', compact('electricCurrent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ElectricCurrent $electricCurrent
    ): View {
        $this->authorize('update', $electricCurrent);

        return view('app.electric_currents.edit', compact('electricCurrent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ElectricCurrentUpdateRequest $request,
        ElectricCurrent $electricCurrent
    ): RedirectResponse {
        $this->authorize('update', $electricCurrent);

        $validated = $request->validated();

        $electricCurrent->update($validated);

        return redirect()
            ->route('electric-currents.edit', $electricCurrent)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ElectricCurrent $electricCurrent
    ): RedirectResponse {
        $this->authorize('delete', $electricCurrent);

        $electricCurrent->delete();

        return redirect()
            ->route('electric-currents.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
