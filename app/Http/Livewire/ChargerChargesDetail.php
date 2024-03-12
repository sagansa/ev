<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Charge;
use Livewire\Component;
use App\Models\Charger;
use App\Models\Vehicle;
use Illuminate\View\View;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ChargerLocation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChargerChargesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Charger $charger;
    public Charge $charge;
    public $vehiclesForSelect = [];
    public $chargerLocationsForSelect = [];
    public $usersForSelect = [];
    public $chargeImage;
    public $uploadIteration = 0;
    public $chargeDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Charge';

    protected $rules = [
        'chargeImage' => ['nullable', 'image', 'max:1024'],
        'charge.vehicle_id' => ['required', 'exists:vehicles,id'],
        'chargeDate' => ['required', 'date'],
        'charge.charger_location_id' => [
            'required',
            'exists:charger_locations,id',
        ],
        'charge.km_now' => ['required', 'numeric'],
        'charge.km_before' => ['required', 'numeric'],
        'charge.battery_start_charging' => ['required', 'numeric'],
        'charge.battery_finish_charging' => ['nullable', 'numeric'],
        'charge.battery_finish_before' => ['required', 'numeric'],
        'charge.parking' => ['nullable', 'numeric'],
        'charge.kWh' => ['nullable', 'numeric'],
        'charge.PPJ' => ['nullable', 'numeric'],
        'charge.PPN' => ['nullable', 'numeric'],
        'charge.admin_cost' => ['nullable', 'numeric'],
        'charge.total_cost' => ['nullable', 'numeric'],
        'charge.user_id' => ['required', 'exists:users,id'],
    ];

    public function mount(Charger $charger): void
    {
        $this->charger = $charger;
        $this->vehiclesForSelect = Vehicle::pluck('image', 'id');
        $this->chargerLocationsForSelect = ChargerLocation::pluck('name', 'id');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetChargeData();
    }

    public function resetChargeData(): void
    {
        $this->charge = new Charge();

        $this->chargeImage = null;
        $this->chargeDate = null;
        $this->charge->vehicle_id = null;
        $this->charge->charger_location_id = null;
        $this->charge->user_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCharge(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.charger_charges.new_title');
        $this->resetChargeData();

        $this->showModal();
    }

    public function editCharge(Charge $charge): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.charger_charges.edit_title');
        $this->charge = $charge;

        $this->chargeDate = optional($this->charge->date)->format('Y-m-d');

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

        if (!$this->charge->charger_id) {
            $this->authorize('create', Charge::class);

            $this->charge->charger_id = $this->charger->id;
        } else {
            $this->authorize('update', $this->charge);
        }

        if ($this->chargeImage) {
            $this->charge->image = $this->chargeImage->store('public');
        }

        $this->charge->date = \Carbon\Carbon::make($this->chargeDate);

        $this->charge->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Charge::class);

        collect($this->selected)->each(function (string $id) {
            $charge = Charge::findOrFail($id);

            if ($charge->image) {
                Storage::delete($charge->image);
            }

            $charge->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetChargeData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->charger->charges as $charge) {
            array_push($this->selected, $charge->id);
        }
    }

    public function render(): View
    {
        return view('livewire.charger-charges-detail', [
            'charges' => $this->charger->charges()->paginate(20),
        ]);
    }
}
