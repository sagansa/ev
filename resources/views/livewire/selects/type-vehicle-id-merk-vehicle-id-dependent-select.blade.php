<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="type_vehicle_id"
            label="Type Vehicle"
            wire:model="selectedTypeVehicleId"
        >
            <option selected>Please select the Type Vehicle</option>
            @foreach($allTypeVehicles as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedTypeVehicleId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="merk_vehicle_id"
            label="Merk Vehicle"
            wire:model="selectedMerkVehicleId"
        >
            <option selected>Please select the Merk Vehicle</option>
            @foreach($allMerkVehicles as $id => $merk)
            <option value="{{ $id }}">{{ $merk }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
