<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\SubMerkVehicle;
use App\Models\ElectricCurrent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubMerkVehicleElectricCurrentsDetail extends Component
{
    use AuthorizesRequests;

    public SubMerkVehicle $subMerkVehicle;
    public ElectricCurrent $electricCurrent;
    public $electricCurrentsForSelect = [];
    public $electric_current_id = null;
    public $Max_charge_capacity;
    public $charging_percentage;
    public $charging_time;

    public $showingModal = false;
    public $modalTitle = 'New ElectricCurrent';

    protected $rules = [
        'electric_current_id' => ['required', 'exists:electric_currents,id'],
        'Max_charge_capacity' => ['nullable', 'max:255', 'string'],
        'charging_percentage' => ['nullable', 'max:20', 'string'],
        'charging_time' => ['nullable', 'max:20', 'string'],
    ];

    public function mount(SubMerkVehicle $subMerkVehicle): void
    {
        $this->subMerkVehicle = $subMerkVehicle;
        $this->electricCurrentsForSelect = ElectricCurrent::pluck('name', 'id');
        $this->resetElectricCurrentData();
    }

    public function resetElectricCurrentData(): void
    {
        $this->electricCurrent = new ElectricCurrent();

        $this->electric_current_id = null;
        $this->Max_charge_capacity = null;
        $this->charging_percentage = null;
        $this->charging_time = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newElectricCurrent(): void
    {
        $this->modalTitle = trans(
            'crud.sub_merk_vehicle_electric_currents.new_title'
        );
        $this->resetElectricCurrentData();

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
        $this->validate();

        $this->authorize('create', ElectricCurrent::class);

        $this->subMerkVehicle
            ->electricCurrents()
            ->attach($this->electricCurrent_id, [
                'Max_charge_capacity' => $this->Max_charge_capacity,
                'charging_percentage' => $this->charging_percentage,
                'charging_time' => $this->charging_time,
            ]);

        $this->hideModal();
    }

    public function detach($electricCurrent): void
    {
        $this->authorize('delete-any', ElectricCurrent::class);

        $this->subMerkVehicle->electricCurrents()->detach($electricCurrent);

        $this->resetElectricCurrentData();
    }

    public function render(): View
    {
        return view('livewire.sub-merk-vehicle-electric-currents-detail', [
            'subMerkVehicleElectricCurrents' => $this->subMerkVehicle
                ->electricCurrents()
                ->withPivot([
                    'Max_charge_capacity',
                    'charging_percentage',
                    'charging_time',
                ])
                ->paginate(20),
        ]);
    }
}
