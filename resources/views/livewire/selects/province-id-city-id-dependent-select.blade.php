<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="province_id"
            label="Province"
            wire:model="selectedProvinceId"
        >
            <option selected>Please select the Province</option>
            @foreach($allProvinces as $id => $province)
            <option value="{{ $id }}">{{ $province }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedProvinceId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="city_id"
            label="City"
            wire:model="selectedCityId"
        >
            <option selected>Please select the City</option>
            @foreach($allCities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
