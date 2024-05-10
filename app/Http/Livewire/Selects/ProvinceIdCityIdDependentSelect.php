<?php

namespace App\Http\Livewire\Selects;

use App\Models\City;
use Livewire\Component;
use App\Models\Province;
use Illuminate\View\View;
use App\Models\ChargerLocation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProvinceIdCityIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allProvinces;
    public $allCities;

    public $selectedProvinceId;
    public $selectedCityId;

    protected $rules = [
        'selectedProvinceId' => ['required', 'exists:provinces,id'],
        'selectedCityId' => ['required', 'exists:cities,id'],
    ];

    public function mount($chargerLocation): void
    {
        $this->clearData();
        $this->fillAllProvinces();

        if (is_null($chargerLocation)) {
            return;
        }

        $chargerLocation = ChargerLocation::findOrFail($chargerLocation);

        $this->selectedProvinceId = $chargerLocation->province_id;

        $this->fillAllCities();
        $this->selectedCityId = $chargerLocation->city_id;
    }

    public function updatedSelectedProvinceId(): void
    {
        $this->selectedCityId = null;
        $this->fillAllCities();
    }

    public function fillAllProvinces(): void
    {
        $this->allProvinces = Province::all()->pluck('province', 'id');
    }

    public function fillAllCities(): void
    {
        if (!$this->selectedProvinceId) {
            return;
        }

        $this->allCities = City::where('province_id', $this->selectedProvinceId)
            ->get()
            ->pluck('city', 'id');
    }

    public function clearData(): void
    {
        $this->allProvinces = null;
        $this->allCities = null;

        $this->selectedProvinceId = null;
        $this->selectedCityId = null;
    }

    public function render(): View
    {
        return view('livewire.selects.province-id-city-id-dependent-select');
    }
}
