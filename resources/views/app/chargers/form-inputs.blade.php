@php $editing = isset($charger) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="charger_location_id"
            label="Charger Location"
            required
        >
            @php $selected = old('charger_location_id', ($editing ? $charger->charger_location_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Charger Location</option>
            @foreach($chargerLocations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="charger_type_id" label="Charger Type" required>
            @php $selected = old('charger_type_id', ($editing ? $charger->charger_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Charger Type</option>
            @foreach($chargerTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="electric_current_id"
            label="Electric Current"
            required
        >
            @php $selected = old('electric_current_id', ($editing ? $charger->electric_current_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Electric Current</option>
            @foreach($electricCurrents as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="power"
            label="Power"
            :value="old('power', ($editing ? $charger->power : ''))"
            maxlength="10"
            placeholder="Power"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="unit"
            label="Unit"
            :value="old('unit', ($editing ? $charger->unit : ''))"
            placeholder="Unit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="charge_cost"
            label="Charge Cost"
            :value="old('charge_cost', ($editing ? $charger->charge_cost : ''))"
            min="00"
            placeholder="Charge Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="PPJ"
            label="PPJ"
            :value="old('PPJ', ($editing ? $charger->PPJ : ''))"
            max="100"
            placeholder="PPJ"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="admin_cost"
            label="Admin Cost"
            :value="old('admin_cost', ($editing ? $charger->admin_cost : ''))"
            placeholder="Admin Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="PPN" label="PPN">
            @php $selected = old('PPN', ($editing ? $charger->PPN : '')) @endphp
            <option value="yes" {{ $selected == 'yes' ? 'selected' : '' }} >Yes</option>
            <option value="no" {{ $selected == 'no' ? 'selected' : '' }} >No</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $charger->status : 'not verified')) @endphp
            <option value="verified" {{ $selected == 'verified' ? 'selected' : '' }} >Verified</option>
            <option value="not verified" {{ $selected == 'not verified' ? 'selected' : '' }} >Not verified</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $charger->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
