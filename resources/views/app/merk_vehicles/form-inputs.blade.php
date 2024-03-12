@php $editing = isset($merkVehicle) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="type_vehicle_id" label="Type Vehicle" required>
            @php $selected = old('type_vehicle_id', ($editing ? $merkVehicle->type_vehicle_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Type Vehicle</option>
            @foreach($typeVehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="merk"
            label="Merk"
            :value="old('merk', ($editing ? $merkVehicle->merk : ''))"
            maxlength="20"
            placeholder="Merk"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
