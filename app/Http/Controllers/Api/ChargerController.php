<?php

namespace App\Http\Controllers\Api;

use App\Models\Charger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerResource;
use App\Http\Resources\ChargerCollection;
use App\Http\Requests\ChargerStoreRequest;
use App\Http\Requests\ChargerUpdateRequest;

class ChargerController extends Controller
{
    public function index(Request $request): ChargerCollection
    {
        $this->authorize('view-any', Charger::class);

        $search = $request->get('search', '');

        $chargers = Charger::search($search)
            ->latest()
            ->paginate();

        return new ChargerCollection($chargers);
    }

    public function store(ChargerStoreRequest $request): ChargerResource
    {
        $this->authorize('create', Charger::class);

        $validated = $request->validated();

        $charger = Charger::create($validated);

        return new ChargerResource($charger);
    }

    public function show(Request $request, Charger $charger): ChargerResource
    {
        $this->authorize('view', $charger);

        return new ChargerResource($charger);
    }

    public function update(
        ChargerUpdateRequest $request,
        Charger $charger
    ): ChargerResource {
        $this->authorize('update', $charger);

        $validated = $request->validated();

        $charger->update($validated);

        return new ChargerResource($charger);
    }

    public function destroy(Request $request, Charger $charger): Response
    {
        $this->authorize('delete', $charger);

        $charger->delete();

        return response()->noContent();
    }
}
