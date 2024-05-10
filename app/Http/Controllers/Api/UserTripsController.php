<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripCollection;

class UserTripsController extends Controller
{
    public function index(Request $request, User $user): TripCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $trips = $user
            ->trips()
            ->search($search)
            ->latest()
            ->paginate();

        return new TripCollection($trips);
    }

    public function store(Request $request, User $user): TripResource
    {
        $this->authorize('create', Trip::class);

        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'from' => ['required', 'max:255', 'string'],
            'coordinate_from' => ['required', 'max:255', 'string'],
            'to' => ['required', 'max:255', 'string'],
            'coordinate_to' => ['required', 'max:255', 'string'],
        ]);

        $trip = $user->trips()->create($validated);

        return new TripResource($trip);
    }
}
