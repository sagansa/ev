<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SubMerkVehicle;
use App\Models\ElectricCurrent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ElectricCurrentCollection;

class SubMerkVehicleElectricCurrentsController extends Controller
{
    public function index(
        Request $request,
        SubMerkVehicle $subMerkVehicle
    ): ElectricCurrentCollection {
        $this->authorize('view', $subMerkVehicle);

        $search = $request->get('search', '');

        $electricCurrents = $subMerkVehicle
            ->electricCurrents()
            ->search($search)
            ->latest()
            ->paginate();

        return new ElectricCurrentCollection($electricCurrents);
    }

    public function store(
        Request $request,
        SubMerkVehicle $subMerkVehicle,
        ElectricCurrent $electricCurrent
    ): Response {
        $this->authorize('update', $subMerkVehicle);

        $subMerkVehicle
            ->electricCurrents()
            ->syncWithoutDetaching([$electricCurrent->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        SubMerkVehicle $subMerkVehicle,
        ElectricCurrent $electricCurrent
    ): Response {
        $this->authorize('update', $subMerkVehicle);

        $subMerkVehicle->electricCurrents()->detach($electricCurrent);

        return response()->noContent();
    }
}
