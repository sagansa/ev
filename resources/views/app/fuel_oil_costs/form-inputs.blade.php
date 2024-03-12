@php $editing = isset($fuelOilCost) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="vehicle_id" label="Vehicle" required>
            @php $selected = old('vehicle_id', ($editing ? $fuelOilCost->vehicle_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vehicle</option>
            @foreach($vehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($fuelOilCost->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="fuel_price"
            label="Fuel Price"
            :value="old('fuel_price', ($editing ? $fuelOilCost->fuel_price : ''))"
            placeholder="Fuel Price"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="km_start"
            label="km Start"
            :value="old('km_start', ($editing ? $fuelOilCost->km_start : ''))"
            placeholder="km Start"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="km_end"
            label="km End"
            :value="old('km_end', ($editing ? $fuelOilCost->km_end : ''))"
            placeholder="km End"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $fuelOilCost->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
