@php $editing = isset($stateOfHealth) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $stateOfHealth->image ? \Storage::url($stateOfHealth->image) : '' }}')"
        >
            <x-inputs.partials.label
                name="image"
                label="Image"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>

            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="vehicle_id" label="Vehicle" required>
            @php $selected = old('vehicle_id', ($editing ? $stateOfHealth->vehicle_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vehicle</option>
            @foreach($vehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="km"
            label="km"
            :value="old('km', ($editing ? $stateOfHealth->km : ''))"
            placeholder="km"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="percentage"
            label="Percentage"
            :value="old('percentage', ($editing ? $stateOfHealth->percentage : ''))"
            max="255"
            step="0.01"
            placeholder="Percentage"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="how_to_charge"
            label="How to Charge"
            maxlength="255"
            >{{ old('how_to_charge', ($editing ? $stateOfHealth->how_to_charge :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $stateOfHealth->status : 'not verified')) @endphp
            <option value="not verified" {{ $selected == 'not verified' ? 'selected' : '' }} >Not verified</option>
            <option value="verified" {{ $selected == 'verified' ? 'selected' : '' }} >Verified</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $stateOfHealth->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
