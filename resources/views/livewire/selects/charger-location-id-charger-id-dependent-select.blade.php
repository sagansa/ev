<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="charger_location_id"
            label="Charger Location"
            wire:model="selectedChargerLocationId"
        >
            <option selected>Please select the Charger Location</option>
            @foreach($allChargerLocations as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedChargerLocationId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="charger_id"
            label="Charger"
            wire:model="selectedChargerId"
        >
            <option selected>Please select the Charger</option>
            @foreach($allChargers as $id => $power)
            <option value="{{ $id }}">{{ $power }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
