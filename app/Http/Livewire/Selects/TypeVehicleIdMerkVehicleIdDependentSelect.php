<?php

namespace App\Http\Livewire\Selects;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\SubMerkVehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TypeVehicleIdMerkVehicleIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allTypeVehicles;
    public $allMerkVehicles;

    public $selectedTypeVehicleId;
    public $selectedMerkVehicleId;

    protected $rules = [
        'selectedTypeVehicleId' => ['required', 'exists:type_vehicles,id'],
        'selectedMerkVehicleId' => ['required', 'exists:merk_vehicles,id'],
    ];

    public function mount($subMerkVehicle): void
    {
        $this->clearData();
        $this->fillAllTypeVehicles();

        if (is_null($subMerkVehicle)) {
            return;
        }

        $subMerkVehicle = SubMerkVehicle::findOrFail($subMerkVehicle);

        $this->selectedTypeVehicleId = $subMerkVehicle->type_vehicle_id;

        $this->fillAllMerkVehicles();
        $this->selectedMerkVehicleId = $subMerkVehicle->merk_vehicle_id;
    }

    public function updatedSelectedTypeVehicleId(): void
    {
        $this->selectedMerkVehicleId = null;
        $this->fillAllMerkVehicles();
    }

    public function fillAllTypeVehicles(): void
    {
        $this->allTypeVehicles = TypeVehicle::all()->pluck('type', 'id');
    }

    public function fillAllMerkVehicles(): void
    {
        if (!$this->selectedTypeVehicleId) {
            return;
        }

        $this->allMerkVehicles = MerkVehicle::where(
            'type_vehicle_id',
            $this->selectedTypeVehicleId
        )
            ->get()
            ->pluck('merk', 'id');
    }

    public function clearData(): void
    {
        $this->allTypeVehicles = null;
        $this->allMerkVehicles = null;

        $this->selectedTypeVehicleId = null;
        $this->selectedMerkVehicleId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.type-vehicle-id-merk-vehicle-id-dependent-select'
        );
    }
}
