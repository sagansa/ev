<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SubMerkVehicle;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubMerkVehicleResource;
use App\Http\Resources\SubMerkVehicleCollection;
use App\Http\Requests\SubMerkVehicleStoreRequest;
use App\Http\Requests\SubMerkVehicleUpdateRequest;

class SubMerkVehicleController extends Controller
{
    public function index(Request $request): SubMerkVehicleCollection
    {
        $this->authorize('view-any', SubMerkVehicle::class);

        $search = $request->get('search', '');

        $subMerkVehicles = SubMerkVehicle::search($search)
            ->latest()
            ->paginate();

        return new SubMerkVehicleCollection($subMerkVehicles);
    }

    public function store(
        SubMerkVehicleStoreRequest $request
    ): SubMerkVehicleResource {
        $this->authorize('create', SubMerkVehicle::class);

        $validated = $request->validated();

        $subMerkVehicle = SubMerkVehicle::create($validated);

        return new SubMerkVehicleResource($subMerkVehicle);
    }

    public function show(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): SubMerkVehicleResource {
        $this->authorize('view', $subMerkVehicle);

        return new SubMerkVehicleResource($subMerkVehicle);
    }

    public function update(
        SubMerkVehicleUpdateRequest $request,
        SubMerkVehicle $subMerkVehicle
    ): SubMerkVehicleResource {
        $this->authorize('update', $subMerkVehicle);

        $validated = $request->validated();

        $subMerkVehicle->update($validated);

        return new SubMerkVehicleResource($subMerkVehicle);
    }

    public function destroy(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): Response {
        $this->authorize('delete', $subMerkVehicle);

        $subMerkVehicle->delete();

        return response()->noContent();
    }
}
