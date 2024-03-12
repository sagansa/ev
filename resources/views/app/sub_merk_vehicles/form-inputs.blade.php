@php $editing = isset($subMerkVehicle) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="sub_merk"
            label="Sub Merk"
            :value="old('sub_merk', ($editing ? $subMerkVehicle->sub_merk : ''))"
            placeholder="Sub Merk"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="battery_capacity"
            label="Battery Capacity"
            :value="old('battery_capacity', ($editing ? $subMerkVehicle->battery_capacity : ''))"
            max="255"
            step="0.01"
            placeholder="Battery Capacity"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="charger_type_id" label="Charger Type" required>
            @php $selected = old('charger_type_id', ($editing ? $subMerkVehicle->charger_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Charger Type</option>
            @foreach($chargerTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    @livewire('selects.type-vehicle-id-merk-vehicle-id-dependent-select',
    ['subMerkVehicle' => $editing ? $subMerkVehicle->id : null])
</div>
