<?php

namespace App\Http\Livewire\Selects;

use Livewire\Component;
use App\Models\Vehicle;
use Illuminate\View\View;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\SubMerkVehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TypeVehicleIdMerkVehicleIdSubMerkVehicleIdDependentSelect extends
    Component
{
    use AuthorizesRequests;

    public $allTypeVehicles;
    public $allMerkVehicles;
    public $allSubMerkVehicles;

    public $selectedTypeVehicleId;
    public $selectedMerkVehicleId;
    public $selectedSubMerkVehicleId;

    protected $rules = [
        'selectedTypeVehicleId' => ['required', 'exists:type_vehicles,id'],
        'selectedMerkVehicleId' => ['required', 'exists:merk_vehicles,id'],
        'selectedSubMerkVehicleId' => [
            'required',
            'exists:sub_merk_vehicles,id',
        ],
    ];

    public function mount($vehicle): void
    {
        $this->clearData();
        $this->fillAllTypeVehicles();

        if (is_null($vehicle)) {
            return;
        }

        $vehicle = Vehicle::findOrFail($vehicle);

        $this->selectedTypeVehicleId = $vehicle->type_vehicle_id;

        $this->fillAllMerkVehicles();
        $this->selectedMerkVehicleId = $vehicle->merk_vehicle_id;

        $this->fillAllSubMerkVehicles();
        $this->selectedSubMerkVehicleId = $vehicle->sub_merk_vehicle_id;
    }

    public function updatedSelectedTypeVehicleId(): void
    {
        $this->selectedMerkVehicleId = null;
        $this->fillAllMerkVehicles();
    }

    public function updatedSelectedMerkVehicleId(): void
    {
        $this->selectedSubMerkVehicleId = null;
        $this->fillAllSubMerkVehicles();
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

    public function fillAllSubMerkVehicles(): void
    {
        if (!$this->selectedMerkVehicleId) {
            return;
        }

        $this->allSubMerkVehicles = SubMerkVehicle::where(
            'merk_vehicle_id',
            $this->selectedMerkVehicleId
        )
            ->get()
            ->pluck('sub_merk', 'id');
    }

    public function clearData(): void
    {
        $this->allTypeVehicles = null;
        $this->allMerkVehicles = null;
        $this->allSubMerkVehicles = null;

        $this->selectedTypeVehicleId = null;
        $this->selectedMerkVehicleId = null;
        $this->selectedSubMerkVehicleId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.type-vehicle-id-merk-vehicle-id-sub-merk-vehicle-id-dependent-select'
        );
    }
}
