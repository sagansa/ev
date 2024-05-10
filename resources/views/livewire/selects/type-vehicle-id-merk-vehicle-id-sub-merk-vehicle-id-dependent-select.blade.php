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
    >@endif @if(!empty($selectedMerkVehicleId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="sub_merk_vehicle_id"
            label="Sub Merk Vehicle"
            wire:model="selectedSubMerkVehicleId"
        >
            <option selected>Please select the Sub Merk Vehicle</option>
            @foreach($allSubMerkVehicles as $id => $sub_merk)
            <option value="{{ $id }}">{{ $sub_merk }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
