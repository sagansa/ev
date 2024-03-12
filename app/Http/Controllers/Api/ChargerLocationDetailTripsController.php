<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailTripResource;
use App\Http\Resources\DetailTripCollection;

class ChargerLocationDetailTripsController extends Controller
{
    public function index(
        Request $request,
        ChargerLocation $chargerLocation
    ): DetailTripCollection {
        $this->authorize('view', $chargerLocation);

        $search = $request->get('search', '');

        $detailTrips = $chargerLocation
            ->detailTrips()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailTripCollection($detailTrips);
    }

    public function store(
        Request $request,
        ChargerLocation $chargerLocation
    ): DetailTripResource {
        $this->authorize('create', DetailTrip::class);

        $validated = $request->validate([]);

        $detailTrip = $chargerLocation->detailTrips()->create($validated);

        return new DetailTripResource($detailTrip);
    }
}
