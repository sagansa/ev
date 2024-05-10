<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;

class VehicleTripsController extends Controller
{
    public function index(Request $request, Vehicle $vehicle): TripCollection
    {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $trips = $vehicle
            ->trips()
            ->search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    public function store(Request $request, Vehicle $vehicle): TripResource
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'from' => ['required', 'max:255', 'string'],
            'coordinate_from' => ['required', 'max:255', 'string'],
            'to' => ['required', 'max:255', 'string'],
            'coordinate_to' => ['required', 'max:255', 'string'],
        ]);

        $trip = $vehicle->trips()->create($validated);

        return new TripResource($trip);
    }
}
