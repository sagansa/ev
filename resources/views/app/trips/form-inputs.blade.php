@php $editing = isset($trip) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="vehicle_id" label="Vehicle" required>
            @php $selected = old('vehicle_id', ($editing ? $trip->vehicle_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vehicle</option>
            @foreach($vehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $trip->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="from"
            label="From"
            :value="old('from', ($editing ? $trip->from : ''))"
            maxlength="255"
            placeholder="From"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="coordinate_from"
            label="Coordinate From"
            :value="old('coordinate_from', ($editing ? $trip->coordinate_from : ''))"
            maxlength="255"
            placeholder="Coordinate From"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="to"
            label="To"
            :value="old('to', ($editing ? $trip->to : ''))"
            maxlength="255"
            placeholder="To"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="coordinate_to"
            label="Coordinate To"
            :value="old('coordinate_to', ($editing ? $trip->coordinate_to : ''))"
            maxlength="255"
            placeholder="Coordinate To"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
