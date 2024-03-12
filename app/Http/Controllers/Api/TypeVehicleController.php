<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeVehicleResource;
use App\Http\Resources\TypeVehicleCollection;
use App\Http\Requests\TypeVehicleStoreRequest;
use App\Http\Requests\TypeVehicleUpdateRequest;

class TypeVehicleController extends Controller
{
    public function index(Request $request): TypeVehicleCollection
    {
        $this->authorize('view-any', TypeVehicle::class);

        $search = $request->get('search', '');

        $typeVehicles = TypeVehicle::search($search)
            ->latest()
            ->paginate();

        return new TypeVehicleCollection($typeVehicles);
    }

    public function store(TypeVehicleStoreRequest $request): TypeVehicleResource
    {
        $this->authorize('create', TypeVehicle::class);

        $validated = $request->validated();

        $typeVehicle = TypeVehicle::create($validated);

        return new TypeVehicleResource($typeVehicle);
    }

    public function show(
        Request $request,
        TypeVehicle $typeVehicle
    ): TypeVehicleResource {
        $this->authorize('view', $typeVehicle);

        return new TypeVehicleResource($typeVehicle);
    }

    public function update(
        TypeVehicleUpdateRequest $request,
        TypeVehicle $typeVehicle
    ): TypeVehicleResource {
        $this->authorize('update', $typeVehicle);

        $validated = $request->validated();

        $typeVehicle->update($validated);

        return new TypeVehicleResource($typeVehicle);
    }

    public function destroy(
        Request $request,
        TypeVehicle $typeVehicle
    ): Response {
        $this->authorize('delete', $typeVehicle);

        $typeVehicle->delete();

        return response()->noContent();
    }
}
