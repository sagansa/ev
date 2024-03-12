@php $editing = isset($city) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="city"
            label="City"
            :value="old('city', ($editing ? $city->city : ''))"
            maxlength="255"
            placeholder="City"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="province_id" label="Province" required>
            @php $selected = old('province_id', ($editing ? $city->province_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Province</option>
            @foreach($provinces as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
