<?php

namespace App\Http\Controllers\Api;

use App\Models\MerkVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MerkVehicleResource;
use App\Http\Resources\MerkVehicleCollection;
use App\Http\Requests\MerkVehicleStoreRequest;
use App\Http\Requests\MerkVehicleUpdateRequest;

class MerkVehicleController extends Controller
{
    public function index(Request $request): MerkVehicleCollection
    {
        $this->authorize('view-any', MerkVehicle::class);

        $search = $request->get('search', '');

        $merkVehicles = MerkVehicle::search($search)
            ->latest()
            ->paginate();

        return new MerkVehicleCollection($merkVehicles);
    }

    public function store(MerkVehicleStoreRequest $request): MerkVehicleResource
    {
        $this->authorize('create', MerkVehicle::class);

        $validated = $request->validated();

        $merkVehicle = MerkVehicle::create($validated);

        return new MerkVehicleResource($merkVehicle);
    }

    public function show(
        Request $request,
        MerkVehicle $merkVehicle
    ): MerkVehicleResource {
        $this->authorize('view', $merkVehicle);

        return new MerkVehicleResource($merkVehicle);
    }

    public function update(
        MerkVehicleUpdateRequest $request,
        MerkVehicle $merkVehicle
    ): MerkVehicleResource {
        $this->authorize('update', $merkVehicle);

        $validated = $request->validated();

        $merkVehicle->update($validated);

        return new MerkVehicleResource($merkVehicle);
    }

    public function destroy(
        Request $request,
        MerkVehicle $merkVehicle
    ): Response {
        $this->authorize('delete', $merkVehicle);

        $merkVehicle->delete();

        return response()->noContent();
    }
}
