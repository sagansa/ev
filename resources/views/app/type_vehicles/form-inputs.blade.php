@php $editing = isset($typeVehicle) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="type"
            label="Type"
            :value="old('type', ($editing ? $typeVehicle->type : ''))"
            maxlength="20"
            placeholder="Type"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
