<?php

namespace App\Http\Controllers\Api;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ProviderCollection;
use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;

class ProviderController extends Controller
{
    public function index(Request $request): ProviderCollection
    {
        $this->authorize('view-any', Provider::class);

        $search = $request->get('search', '');

        $providers = Provider::search($search)
            ->latest()
            ->paginate();

        return new ProviderCollection($providers);
    }

    public function store(ProviderStoreRequest $request): ProviderResource
    {
        $this->authorize('create', Provider::class);

        $validated = $request->validated();

        $provider = Provider::create($validated);

        return new ProviderResource($provider);
    }

    public function show(Request $request, Provider $provider): ProviderResource
    {
        $this->authorize('view', $provider);

        return new ProviderResource($provider);
    }

    public function update(
        ProviderUpdateRequest $request,
        Provider $provider
    ): ProviderResource {
        $this->authorize('update', $provider);

        $validated = $request->validated();

        $provider->update($validated);

        return new ProviderResource($provider);
    }

    public function destroy(Request $request, Provider $provider): Response
    {
        $this->authorize('delete', $provider);

        $provider->delete();

        return response()->noContent();
    }
}
