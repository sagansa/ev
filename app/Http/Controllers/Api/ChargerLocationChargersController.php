<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ChargerLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChargerResource;
use App\Http\Resources\ChargerCollection;

class ChargerLocationChargersController extends Controller
{
    public function index(
        Request $request,
        ChargerLocation $chargerLocation
    ): ChargerCollection {
        $this->authorize('view', $chargerLocation);

        $search = $request->get('search', '');

        $chargers = $chargerLocation
            ->chargers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ChargerCollection($chargers);
    }

    public function store(
        Request $request,
        ChargerLocation $chargerLocation
    ): ChargerResource {
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
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $charger = $chargerLocation->chargers()->create($validated);

        return new ChargerResource($charger);
    }
}
