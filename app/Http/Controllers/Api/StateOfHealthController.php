<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StateOfHealth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\StateOfHealthResource;
use App\Http\Resources\StateOfHealthCollection;
use App\Http\Requests\StateOfHealthStoreRequest;
use App\Http\Requests\StateOfHealthUpdateRequest;

class StateOfHealthController extends Controller
{
    public function index(Request $request): StateOfHealthCollection
    {
        $this->authorize('view-any', StateOfHealth::class);

        $search = $request->get('search', '');

        $stateOfHealths = StateOfHealth::search($search)
            ->latest()
            ->paginate();

        return new StateOfHealthCollection($stateOfHealths);
    }

    public function store(
        StateOfHealthStoreRequest $request
    ): StateOfHealthResource {
        $this->authorize('create', StateOfHealth::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth = StateOfHealth::create($validated);

        return new StateOfHealthResource($stateOfHealth);
    }

    public function show(
        Request $request,
        StateOfHealth $stateOfHealth
    ): StateOfHealthResource {
        $this->authorize('view', $stateOfHealth);

        return new StateOfHealthResource($stateOfHealth);
    }

    public function update(
        StateOfHealthUpdateRequest $request,
        StateOfHealth $stateOfHealth
    ): StateOfHealthResource {
        $this->authorize('update', $stateOfHealth);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($stateOfHealth->image) {
                Storage::delete($stateOfHealth->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $stateOfHealth->update($validated);

        return new StateOfHealthResource($stateOfHealth);
    }

    public function destroy(
        Request $request,
        StateOfHealth $stateOfHealth
    ): Response {
        $this->authorize('delete', $stateOfHealth);

        if ($stateOfHealth->image) {
            Storage::delete($stateOfHealth->image);
        }

        $stateOfHealth->delete();

        return response()->noContent();
    }
}
