<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provider;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Provider::class);

        $search = $request->get('search', '');

        $providers = Provider::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.providers.index', compact('providers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Provider::class);

        $users = User::pluck('name', 'id');

        return view('app.providers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProviderStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Provider::class);

        $validated = $request->validated();

        $provider = Provider::create($validated);

        return redirect()
            ->route('providers.edit', $provider)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Provider $provider): View
    {
        $this->authorize('view', $provider);

        return view('app.providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Provider $provider): View
    {
        $this->authorize('update', $provider);

        $users = User::pluck('name', 'id');

        return view('app.providers.edit', compact('provider', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProviderUpdateRequest $request,
        Provider $provider
    ): RedirectResponse {
        $this->authorize('update', $provider);

        $validated = $request->validated();

        $provider->update($validated);

        return redirect()
            ->route('providers.edit', $provider)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Provider $provider
    ): RedirectResponse {
        $this->authorize('delete', $provider);

        $provider->delete();

        return redirect()
            ->route('providers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
