<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class ProvinceUsersController extends Controller
{
    public function index(Request $request, Province $province): UserCollection
    {
        $this->authorize('view', $province);

        $search = $request->get('search', '');

        $users = $province
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Province $province): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'phone_number' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'city_id' => ['nullable', 'exists:cities,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $province->users()->create($validated);

        return new UserResource($user);
    }
}
