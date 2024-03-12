@php $editing = isset($charge) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $charge->image ? \Storage::url($charge->image) : '' }}')"
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
            @php $selected = old('vehicle_id', ($editing ? $charge->vehicle_id : '')) @endphp
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
            value="{{ old('date', ($editing ? optional($charge->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="battery_start_charging"
            label="Battery Start Charging"
            :value="old('battery_start_charging', ($editing ? $charge->battery_start_charging : ''))"
            max="100"
            placeholder="Battery Start Charging"
            required
        ></x-inputs.number>
    </x-inputs.group>

    @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="battery_finish_charging"
            label="Battery Finish Charging"
            :value="old('battery_finish_charging', ($editing ? $charge->battery_finish_charging : ''))"
            max="100"
            placeholder="Battery Finish Charging"
        ></x-inputs.number>
    </x-inputs.group>
    @endif

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="battery_finish_before"
            label="Battery Finish Before"
            :value="old('battery_finish_before', ($editing ? $charge->battery_finish_before : ''))"
            max="100"
            placeholder="Battery Finish Before"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="km_now"
            label="km Now"
            :value="old('km_now', ($editing ? $charge->km_now : ''))"
            placeholder="km Now"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="km_before"
            label="km Before"
            :value="old('km_before', ($editing ? $charge->km_before : ''))"
            placeholder="km Before"
            required
        ></x-inputs.number>
    </x-inputs.group>

    @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="parking"
            label="Parking"
            :value="old('parking', ($editing ? $charge->parking : '0'))"
            placeholder="Parking"
        ></x-inputs.number>
    </x-inputs.group>
    @endif @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="kWh"
            label="K Wh"
            :value="old('kWh', ($editing ? $charge->kWh : ''))"
            step="0.001"
            placeholder="K Wh"
        ></x-inputs.number>
    </x-inputs.group>
    @endif @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="PPJ"
            label="PPJ"
            :value="old('PPJ', ($editing ? $charge->PPJ : '0'))"
            placeholder="PPJ"
        ></x-inputs.number>
    </x-inputs.group>
    @endif @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="PPN"
            label="PPN"
            :value="old('PPN', ($editing ? $charge->PPN : '0'))"
            placeholder="PPN"
        ></x-inputs.number>
    </x-inputs.group>
    @endif @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="admin_cost"
            label="Admin Cost"
            :value="old('admin_cost', ($editing ? $charge->admin_cost : '0'))"
            placeholder="Admin Cost"
        ></x-inputs.number>
    </x-inputs.group>
    @endif @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="total_cost"
            label="Total Cost"
            :value="old('total_cost', ($editing ? $charge->total_cost : ''))"
            placeholder="Total Cost"
        ></x-inputs.number>
    </x-inputs.group>
    @endif

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $charge->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    @livewire('selects.charger-location-id-charger-id-dependent-select',
    ['charge' => $editing ? $charge->id : null])
</div>
