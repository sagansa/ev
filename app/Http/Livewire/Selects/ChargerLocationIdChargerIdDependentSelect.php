<?php

namespace App\Http\Livewire\Selects;

use App\Models\Charge;
use Livewire\Component;
use App\Models\Charger;
use Illuminate\View\View;
use App\Models\ChargerLocation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChargerLocationIdChargerIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allChargerLocations;
    public $allChargers;

    public $selectedChargerLocationId;
    public $selectedChargerId;

    protected $rules = [
        'selectedChargerLocationId' => [
            'required',
            'exists:charger_locations,id',
        ],
        'selectedChargerId' => ['required', 'exists:chargers,id'],
    ];

    public function mount($charge): void
    {
        $this->clearData();
        $this->fillAllChargerLocations();

        if (is_null($charge)) {
            return;
        }

        $charge = Charge::findOrFail($charge);

        $this->selectedChargerLocationId = $charge->charger_location_id;

        $this->fillAllChargers();
        $this->selectedChargerId = $charge->charger_id;
    }

    public function updatedSelectedChargerLocationId(): void
    {
        $this->selectedChargerId = null;
        $this->fillAllChargers();
    }

    public function fillAllChargerLocations(): void
    {
        $this->allChargerLocations = ChargerLocation::all()->pluck(
            'name',
            'id'
        );
    }

    public function fillAllChargers(): void
    {
        if (!$this->selectedChargerLocationId) {
            return;
        }

        $this->allChargers = Charger::where(
            'charger_location_id',
            $this->selectedChargerLocationId
        )
            ->get()
            ->pluck('power', 'id');
    }

    public function clearData(): void
    {
        $this->allChargerLocations = null;
        $this->allChargers = null;

        $this->selectedChargerLocationId = null;
        $this->selectedChargerId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.charger-location-id-charger-id-dependent-select'
        );
    }
}
