<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TypeVehicleMerkVehiclesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public TypeVehicle $typeVehicle;
    public MerkVehicle $merkVehicle;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New MerkVehicle';

    protected $rules = [
        'merkVehicle.merk' => [
            'required',
            'unique:merk_vehicles,merk',
            'max:20',
            'string',
        ],
    ];

    public function mount(TypeVehicle $typeVehicle): void
    {
        $this->typeVehicle = $typeVehicle;
        $this->resetMerkVehicleData();
    }

    public function resetMerkVehicleData(): void
    {
        $this->merkVehicle = new MerkVehicle();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMerkVehicle(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.type_vehicle_merk_vehicles.new_title');
        $this->resetMerkVehicleData();

        $this->showModal();
    }

    public function editMerkVehicle(MerkVehicle $merkVehicle): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.type_vehicle_merk_vehicles.edit_title');
        $this->merkVehicle = $merkVehicle;

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
        if (!$this->merkVehicle->type_vehicle_id) {
            $this->validate();
        } else {
            $this->validate([
                'merkVehicle.merk' => [
                    'required',
                    Rule::unique('merk_vehicles', 'merk')->ignore(
                        $this->merkVehicle
                    ),
                    'max:20',
                    'string',
                ],
            ]);
        }

        if (!$this->merkVehicle->type_vehicle_id) {
            $this->authorize('create', MerkVehicle::class);

            $this->merkVehicle->type_vehicle_id = $this->typeVehicle->id;
        } else {
            $this->authorize('update', $this->merkVehicle);
        }

        $this->merkVehicle->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', MerkVehicle::class);

        MerkVehicle::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMerkVehicleData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->typeVehicle->merkVehicles as $merkVehicle) {
            array_push($this->selected, $merkVehicle->id);
        }
    }

    public function render(): View
    {
        return view('livewire.type-vehicle-merk-vehicles-detail', [
            'merkVehicles' => $this->typeVehicle->merkVehicles()->paginate(20),
        ]);
    }
}
