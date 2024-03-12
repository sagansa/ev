<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ElectricCurrent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ElectricCurrentResource;
use App\Http\Resources\ElectricCurrentCollection;
use App\Http\Requests\ElectricCurrentStoreRequest;
use App\Http\Requests\ElectricCurrentUpdateRequest;

class ElectricCurrentController extends Controller
{
    public function index(Request $request): ElectricCurrentCollection
    {
        $this->authorize('view-any', ElectricCurrent::class);

        $search = $request->get('search', '');

        $electricCurrents = ElectricCurrent::search($search)
            ->latest()
            ->paginate();

        return new ElectricCurrentCollection($electricCurrents);
    }

    public function store(
        ElectricCurrentStoreRequest $request
    ): ElectricCurrentResource {
        $this->authorize('create', ElectricCurrent::class);

        $validated = $request->validated();

        $electricCurrent = ElectricCurrent::create($validated);

        return new ElectricCurrentResource($electricCurrent);
    }

    public function show(
        Request $request,
        ElectricCurrent $electricCurrent
    ): ElectricCurrentResource {
        $this->authorize('view', $electricCurrent);

        return new ElectricCurrentResource($electricCurrent);
    }

    public function update(
        ElectricCurrentUpdateRequest $request,
        ElectricCurrent $electricCurrent
    ): ElectricCurrentResource {
        $this->authorize('update', $electricCurrent);

        $validated = $request->validated();

        $electricCurrent->update($validated);

        return new ElectricCurrentResource($electricCurrent);
    }

    public function destroy(
        Request $request,
        ElectricCurrent $electricCurrent
    ): Response {
        $this->authorize('delete', $electricCurrent);

        $electricCurrent->delete();

        return response()->noContent();
    }
}
