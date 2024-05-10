<?php

namespace App\Http\Controllers\Api;

use App\Models\ChargerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerResource;
use App\Http\Resources\ChargerCollection;

class ChargerTypeChargersController extends Controller
{
    public function index(
        Request $request,
        ChargerType $chargerType
    ): ChargerCollection {
        $this->authorize('view', $chargerType);

        $search = $request->get('search', '');

        $chargers = $chargerType
            ->chargers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerCollection($chargers);
    }

    public function store(
        Request $request,
        ChargerType $chargerType
    ): ChargerResource {
        $this->authorize('create', Charger::class);

        $validated = $request->validate([
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
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $charger = $chargerType->chargers()->create($validated);

        return new ChargerResource($charger);
    }
}
