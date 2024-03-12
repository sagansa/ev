<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProvinceStoreRequest;
use App\Http\Requests\ProvinceUpdateRequest;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Province::class);

        $search = $request->get('search', '');

        $provinces = Province::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.provinces.index', compact('provinces', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Province::class);

        return view('app.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProvinceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Province::class);

        $validated = $request->validated();

        $province = Province::create($validated);

        return redirect()
            ->route('provinces.edit', $province)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Province $province): View
    {
        $this->authorize('view', $province);

        return view('app.provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Province $province): View
    {
        $this->authorize('update', $province);

        return view('app.provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProvinceUpdateRequest $request,
        Province $province
    ): RedirectResponse {
        $this->authorize('update', $province);

        $validated = $request->validated();

        $province->update($validated);

        return redirect()
            ->route('provinces.edit', $province)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Province $province
    ): RedirectResponse {
        $this->authorize('delete', $province);

        $province->delete();

        return redirect()
            ->route('provinces.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
