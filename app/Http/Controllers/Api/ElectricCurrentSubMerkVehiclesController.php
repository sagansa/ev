<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SubMerkVehicle;
use App\Models\ElectricCurrent;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubMerkVehicleCollection;

class ElectricCurrentSubMerkVehiclesController extends Controller
{
    public function index(
        Request $request,
        ElectricCurrent $electricCurrent
    ): SubMerkVehicleCollection {
        $this->authorize('view', $electricCurrent);

        $search = $request->get('search', '');

        $subMerkVehicles = $electricCurrent
            ->subMerkVehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubMerkVehicleCollection($subMerkVehicles);
    }

    public function store(
        Request $request,
        ElectricCurrent $electricCurrent,
        SubMerkVehicle $subMerkVehicle
    ): Response {
        $this->authorize('update', $electricCurrent);

        $electricCurrent
            ->subMerkVehicles()
            ->syncWithoutDetaching([$subMerkVehicle->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ElectricCurrent $electricCurrent,
        SubMerkVehicle $subMerkVehicle
    ): Response {
        $this->authorize('update', $electricCurrent);

        $electricCurrent->subMerkVehicles()->detach($subMerkVehicle);

        return response()->noContent();
    }
}
