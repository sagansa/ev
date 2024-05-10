<?php

namespace App\Http\Controllers\Api;

use App\Models\ChargerType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerTypeResource;
use App\Http\Resources\ChargerTypeCollection;
use App\Http\Requests\ChargerTypeStoreRequest;
use App\Http\Requests\ChargerTypeUpdateRequest;

class ChargerTypeController extends Controller
{
    public function index(Request $request): ChargerTypeCollection
    {
        $this->authorize('view-any', ChargerType::class);

        $search = $request->get('search', '');

        $chargerTypes = ChargerType::search($search)
            ->latest()
            ->paginate();

        return new ChargerTypeCollection($chargerTypes);
    }

    public function store(ChargerTypeStoreRequest $request): ChargerTypeResource
    {
        $this->authorize('create', ChargerType::class);

        $validated = $request->validated();

        $chargerType = ChargerType::create($validated);

        return new ChargerTypeResource($chargerType);
    }

    public function show(
        Request $request,
        ChargerType $chargerType
    ): ChargerTypeResource {
        $this->authorize('view', $chargerType);

        return new ChargerTypeResource($chargerType);
    }

    public function update(
        ChargerTypeUpdateRequest $request,
        ChargerType $chargerType
    ): ChargerTypeResource {
        $this->authorize('update', $chargerType);

        $validated = $request->validated();

        $chargerType->update($validated);

        return new ChargerTypeResource($chargerType);
    }

    public function destroy(
        Request $request,
        ChargerType $chargerType
    ): Response {
        $this->authorize('delete', $chargerType);

        $chargerType->delete();

        return response()->noContent();
    }
}
