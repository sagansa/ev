<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ElectricCurrent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerResource;
use App\Http\Resources\ChargerCollection;

class ElectricCurrentChargersController extends Controller
{
    public function index(
        Request $request,
        ElectricCurrent $electricCurrent
    ): ChargerCollection {
        $this->authorize('view', $electricCurrent);

        $search = $request->get('search', '');

        $chargers = $electricCurrent
            ->chargers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerCollection($chargers);
    }

    public function store(
        Request $request,
        ElectricCurrent $electricCurrent
    ): ChargerResource {
        $this->authorize('create', Charger::class);

        $validated = $request->validate([
            'charger_type_id' => ['required', 'exists:charger_types,id'],
            'power' => ['required', 'max:10', 'string'],
            'unit' => ['required', 'max:255'],
            'charge_cost' => ['required', 'numeric'],
            'PPJ' => ['required', 'numeric'],
            'admin_cost' => ['required', 'numeric'],
            'PPN' => ['required', 'in:yes,no'],
            'status' => ['required', 'in:verified,not verified,closed'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $charger = $electricCurrent->chargers()->create($validated);

        return new ChargerResource($charger);
    }
}
