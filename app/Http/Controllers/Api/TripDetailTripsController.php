<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailTripResource;
use App\Http\Resources\DetailTripCollection;

class TripDetailTripsController extends Controller
{
    public function index(Request $request, Trip $trip): DetailTripCollection
    {
        $this->authorize('view', $trip);

        $search = $request->get('search', '');

        $detailTrips = $trip
            ->detailTrips()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailTripCollection($detailTrips);
    }

    public function store(Request $request, Trip $trip): DetailTripResource
    {
        $this->authorize('create', DetailTrip::class);

        $validated = $request->validate([]);

        $detailTrip = $trip->detailTrips()->create($validated);

        return new DetailTripResource($detailTrip);
    }
}
