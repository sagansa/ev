<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\ProvinceCollection;
use App\Http\Requests\ProvinceStoreRequest;
use App\Http\Requests\ProvinceUpdateRequest;

class ProvinceController extends Controller
{
    public function index(Request $request): ProvinceCollection
    {
        $this->authorize('view-any', Province::class);

        $search = $request->get('search', '');

        $provinces = Province::search($search)
            ->latest()
            ->paginate();

        return new ProvinceCollection($provinces);
    }

    public function store(ProvinceStoreRequest $request): ProvinceResource
    {
        $this->authorize('create', Province::class);

        $validated = $request->validated();

        $province = Province::create($validated);

        return new ProvinceResource($province);
    }

    public function show(Request $request, Province $province): ProvinceResource
    {
        $this->authorize('view', $province);

        return new ProvinceResource($province);
    }

    public function update(
        ProvinceUpdateRequest $request,
        Province $province
    ): ProvinceResource {
        $this->authorize('update', $province);

        $validated = $request->validated();

        $province->update($validated);

        return new ProvinceResource($province);
    }

    public function destroy(Request $request, Province $province): Response
    {
        $this->authorize('delete', $province);

        $province->delete();

        return response()->noContent();
    }
}
