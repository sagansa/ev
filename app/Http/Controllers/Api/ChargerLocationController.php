<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ChargerLocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ChargerLocationResource;
use App\Http\Resources\ChargerLocationCollection;
use App\Http\Requests\ChargerLocationStoreRequest;
use App\Http\Requests\ChargerLocationUpdateRequest;

class ChargerLocationController extends Controller
{
    public function index(Request $request): ChargerLocationCollection
    {
        $this->authorize('view-any', ChargerLocation::class);

        $search = $request->get('search', '');

        $chargerLocations = ChargerLocation::search($search)
            ->latest()
            ->paginate();

        return new ChargerLocationCollection($chargerLocations);
    }

    public function store(
        ChargerLocationStoreRequest $request
    ): ChargerLocationResource {
        $this->authorize('create', ChargerLocation::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation = ChargerLocation::create($validated);

        return new ChargerLocationResource($chargerLocation);
    }

    public function show(
        Request $request,
        ChargerLocation $chargerLocation
    ): ChargerLocationResource {
        $this->authorize('view', $chargerLocation);

        return new ChargerLocationResource($chargerLocation);
    }

    public function update(
        ChargerLocationUpdateRequest $request,
        ChargerLocation $chargerLocation
    ): ChargerLocationResource {
        $this->authorize('update', $chargerLocation);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($chargerLocation->image) {
                Storage::delete($chargerLocation->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $chargerLocation->update($validated);

        return new ChargerLocationResource($chargerLocation);
    }

    public function destroy(
        Request $request,
        ChargerLocation $chargerLocation
    ): Response {
        $this->authorize('delete', $chargerLocation);

        if ($chargerLocation->image) {
            Storage::delete($chargerLocation->image);
        }

        $chargerLocation->delete();

        return response()->noContent();
    }
}
