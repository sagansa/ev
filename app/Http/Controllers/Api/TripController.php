<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;
use App\Http\Requests\TripStoreRequest;
use App\Http\Requests\TripUpdateRequest;

class TripController extends Controller
{
    public function index(Request $request): TripCollection
    {
        $this->authorize('view-any', Trip::class);

        $search = $request->get('search', '');

        $trips = Trip::search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    public function store(TripStoreRequest $request): TripResource
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validated();

        $trip = Trip::create($validated);

        return new TripResource($trip);
    }

    public function show(Request $request, Trip $trip): TripResource
    {
        $this->authorize('view', $trip);

        return new TripResource($trip);
    }

    public function update(TripUpdateRequest $request, Trip $trip): TripResource
    {
        $this->authorize('update', $trip);

        $validated = $request->validated();

        $trip->update($validated);

        return new TripResource($trip);
    }

    public function destroy(Request $request, Trip $trip): Response
    {
        $this->authorize('delete', $trip);

        $trip->delete();

        return response()->noContent();
    }
}
