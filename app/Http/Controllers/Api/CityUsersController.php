<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class CityUsersController extends Controller
{
    public function index(Request $request, City $city): UserCollection
    {
        $this->authorize('view', $city);

        $search = $request->get('search', '');

        $users = $city
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, City $city): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'phone_number' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $city->users()->create($validated);

        return new UserResource($user);
    }
}
