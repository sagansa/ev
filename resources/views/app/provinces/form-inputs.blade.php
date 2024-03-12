@php $editing = isset($province) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="province"
            label="Province"
            :value="old('province', ($editing ? $province->province : ''))"
            maxlength="255"
            placeholder="Province"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
