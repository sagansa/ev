<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Charger;
use Illuminate\View\View;
use App\Models\ChargerType;
use Livewire\WithPagination;
use App\Models\ChargerLocation;
use App\Models\ElectricCurrent;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChargerLocationChargersDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public ChargerLocation $chargerLocation;
    public Charger $charger;
    public $chargerTypesForSelect = [];
    public $electricCurrentsForSelect = [];
    public $usersForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Charger';

    protected $rules = [
        'charger.charger_type_id' => ['required', 'exists:charger_types,id'],
        'charger.electric_current_id' => [
            'required',
            'exists:electric_currents,id',
        ],
        'charger.power' => ['required', 'max:10', 'string'],
        'charger.unit' => ['required', 'max:255'],
        'charger.charge_cost' => ['required', 'numeric'],
        'charger.PPJ' => ['required', 'numeric'],
        'charger.admin_cost' => ['required', 'numeric'],
        'charger.PPN' => ['required', 'in:yes,no'],
        'charger.status' => ['required', 'in:verified,not verified,closed'],
        'charger.user_id' => ['required', 'exists:users,id'],
    ];

    public function mount(ChargerLocation $chargerLocation): void
    {
        $this->chargerLocation = $chargerLocation;
        $this->chargerTypesForSelect = ChargerType::pluck('name', 'id');
        $this->electricCurrentsForSelect = ElectricCurrent::pluck('name', 'id');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetChargerData();
    }

    public function resetChargerData(): void
    {
        $this->charger = new Charger();

        $this->charger->charger_type_id = null;
        $this->charger->electric_current_id = null;
        $this->charger->PPN = 'yes';
        $this->charger->status = 'not verified';
        $this->charger->user_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCharger(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.charger_location_chargers.new_title');
        $this->resetChargerData();

        $this->showModal();
    }

    public function editCharger(Charger $charger): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.charger_location_chargers.edit_title');
        $this->charger = $charger;

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
        $this->validate();

        if (!$this->charger->charger_location_id) {
            $this->authorize('create', Charger::class);

            $this->charger->charger_location_id = $this->chargerLocation->id;
        } else {
            $this->authorize('update', $this->charger);
        }

        $this->charger->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Charger::class);

        Charger::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetChargerData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->chargerLocation->chargers as $charger) {
            array_push($this->selected, $charger->id);
        }
    }

    public function render(): View
    {
        return view('livewire.charger-location-chargers-detail', [
            'chargers' => $this->chargerLocation->chargers()->paginate(20),
        ]);
    }
}
