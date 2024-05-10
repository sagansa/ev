<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StateOfHealthResource;
use App\Http\Resources\StateOfHealthCollection;

class UserStateOfHealthsController extends Controller
{
    public function index(Request $request, User $user): StateOfHealthCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $stateOfHealths = $user
            ->stateOfHealths()
            ->search($search)
            ->latest()
            ->paginate();

        return new StateOfHealthCollection($stateOfHealths);
    }

    public function store(Request $request, User $user): StateOfHealthResource
    {
        $this->authorize('create', StateOfHealth::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'km' => ['required', 'numeric'],
            'percentage' => ['required', 'numeric'],
            'how_to_charge' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'in:not verified,verified'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth = $user->stateOfHealths()->create($validated);

        return new StateOfHealthResource($stateOfHealth);
    }
}
