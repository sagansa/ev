<?php

namespace App\Http\Livewire;

use App\Models\Trip;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\DetailTrip;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TripDetailTripsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Trip $trip;
    public DetailTrip $detailTrip;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DetailTrip';

    protected $rules = [];

    public function mount(Trip $trip): void
    {
        $this->trip = $trip;
        $this->resetDetailTripData();
    }

    public function resetDetailTripData(): void
    {
        $this->detailTrip = new DetailTrip();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDetailTrip(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.trip_detail_trips.new_title');
        $this->resetDetailTripData();

        $this->showModal();
    }

    public function editDetailTrip(DetailTrip $detailTrip): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.trip_detail_trips.edit_title');
        $this->detailTrip = $detailTrip;

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

        if (!$this->detailTrip->trip_id) {
            $this->authorize('create', DetailTrip::class);

            $this->detailTrip->trip_id = $this->trip->id;
        } else {
            $this->authorize('update', $this->detailTrip);
        }

        $this->detailTrip->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DetailTrip::class);

        DetailTrip::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDetailTripData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->trip->detailTrips as $detailTrip) {
            array_push($this->selected, $detailTrip->id);
        }
    }

    public function render(): View
    {
        return view('livewire.trip-detail-trips-detail', [
            'detailTrips' => $this->trip->detailTrips()->paginate(20),
        ]);
    }
}
