<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerResource;
use App\Http\Resources\ChargerCollection;

class UserChargersController extends Controller
{
    public function index(Request $request, User $user): ChargerCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $chargers = $user
            ->chargers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerCollection($chargers);
    }

    public function store(Request $request, User $user): ChargerResource
    {
        $this->authorize('create', Charger::class);

        $validated = $request->validate([
            'charger_type_id' => ['required', 'exists:charger_types,id'],
            'electric_current_id' => [
                'required',
                'exists:electric_currents,id',
            ],
            'power' => ['required', 'max:10', 'string'],
            'unit' => ['required', 'max:255'],
            'charge_cost' => ['required', 'numeric'],
            'PPJ' => ['required', 'numeric'],
            'admin_cost' => ['required', 'numeric'],
            'PPN' => ['required', 'in:yes,no'],
            'status' => ['required', 'in:verified,not verified,closed'],
        ]);

        $charger = $user->chargers()->create($validated);

        return new ChargerResource($charger);
    }
}
