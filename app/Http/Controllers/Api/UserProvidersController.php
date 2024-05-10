<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ProviderCollection;

class UserProvidersController extends Controller
{
    public function index(Request $request, User $user): ProviderCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $providers = $user
            ->providers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProviderCollection($providers);
    }

    public function store(Request $request, User $user): ProviderResource
    {
        $this->authorize('create', Provider::class);

        $validated = $request->validate([
            'name' => ['required', 'unique:providers,name', 'max:20', 'string'],
            'status' => ['required', 'in:inactive,active,not verified'],
        ]);

        $provider = $user->providers()->create($validated);

        return new ProviderResource($provider);
    }
}
