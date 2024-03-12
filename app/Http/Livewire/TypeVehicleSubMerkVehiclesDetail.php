<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\ChargerType;
use Livewire\WithPagination;
use App\Models\SubMerkVehicle;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TypeVehicleSubMerkVehiclesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public TypeVehicle $typeVehicle;
    public SubMerkVehicle $subMerkVehicle;
    public $merkVehiclesForSelect = [];
    public $chargerTypesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SubMerkVehicle';

    protected $rules = [
        'subMerkVehicle.merk_vehicle_id' => [
            'required',
            'exists:merk_vehicles,id',
        ],
        'subMerkVehicle.sub_merk' => [
            'required',
            'unique:sub_merk_vehicles,sub_merk',
            'max:30',
            'string',
        ],
        'subMerkVehicle.battery_capacity' => ['required', 'numeric'],
        'subMerkVehicle.charger_type_id' => [
            'required',
            'exists:charger_types,id',
        ],
    ];

    public function mount(TypeVehicle $typeVehicle): void
    {
        $this->typeVehicle = $typeVehicle;
        $this->merkVehiclesForSelect = MerkVehicle::pluck('merk', 'id');
        $this->chargerTypesForSelect = ChargerType::pluck('name', 'id');
        $this->resetSubMerkVehicleData();
    }

    public function resetSubMerkVehicleData(): void
    {
        $this->subMerkVehicle = new SubMerkVehicle();

        $this->subMerkVehicle->merk_vehicle_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSubMerkVehicle(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.type_vehicle_sub_merk_vehicles.new_title'
        );
        $this->resetSubMerkVehicleData();

        $this->showModal();
    }

    public function editSubMerkVehicle(SubMerkVehicle $subMerkVehicle): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.type_vehicle_sub_merk_vehicles.edit_title'
        );
        $this->subMerkVehicle = $subMerkVehicle;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        if (!$this->subMerkVehicle->type_vehicle_id) {
            $this->validate();
        } else {
            $this->validate([
                'subMerkVehicle.merk_vehicle_id' => [
                    'required',
                    'exists:merk_vehicles,id',
                ],
                'subMerkVehicle.sub_merk' => [
                    'required',
                    Rule::unique('sub_merk_vehicles', 'sub_merk')->ignore(
                        $this->subMerkVehicle
                    ),
                    'max:30',
                    'string',
                ],
                'subMerkVehicle.battery_capacity' => ['required', 'numeric'],
                'subMerkVehicle.charger_type_id' => [
                    'required',
                    'exists:charger_types,id',
                ],
            ]);
        }

        if (!$this->subMerkVehicle->type_vehicle_id) {
            $this->authorize('create', SubMerkVehicle::class);

            $this->subMerkVehicle->type_vehicle_id = $this->typeVehicle->id;
        } else {
            $this->authorize('update', $this->subMerkVehicle);
        }

        $this->subMerkVehicle->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SubMerkVehicle::class);

        SubMerkVehicle::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSubMerkVehicleData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->typeVehicle->subMerkVehicles as $subMerkVehicle) {
            array_push($this->selected, $subMerkVehicle->id);
        }
    }

    public function render(): View
    {
        return view('livewire.type-vehicle-sub-merk-vehicles-detail', [
            'subMerkVehicles' => $this->typeVehicle
                ->subMerkVehicles()
                ->paginate(20),
        ]);
    }
}
