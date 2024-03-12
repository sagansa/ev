@php $editing = isset($electricCurrent) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="name" label="Name">
            @php $selected = old('name', ($editing ? $electricCurrent->name : '')) @endphp
            <option value="AC" {{ $selected == 'AC' ? 'selected' : '' }} >AC</option>
            <option value="DC" {{ $selected == 'DC' ? 'selected' : '' }} >DC</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
