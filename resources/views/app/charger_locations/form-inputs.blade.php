@php $editing = isset($chargerLocation) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $chargerLocation->image ? \Storage::url($chargerLocation->image) : '' }}')"
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
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $chargerLocation->name : ''))"
            maxlength="100"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="provider_id" label="Provider" required>
            @php $selected = old('provider_id', ($editing ? $chargerLocation->provider_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Provider</option>
            @foreach($providers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="location_on" label="Location On">
            @php $selected = old('location_on', ($editing ? $chargerLocation->location_on : 'public')) @endphp
            <option value="closed" {{ $selected == 'closed' ? 'selected' : '' }} >Closed</option>
            <option value="dealer" {{ $selected == 'dealer' ? 'selected' : '' }} >Dealer</option>
            <option value="private" {{ $selected == 'private' ? 'selected' : '' }} >Private</option>
            <option value="public" {{ $selected == 'public' ? 'selected' : '' }} >Public</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="system" label="System">
            @php $selected = old('system', ($editing ? $chargerLocation->system : '')) @endphp
            <option value="free" {{ $selected == 'free' ? 'selected' : '' }} >Free</option>
            <option value="hour_base" {{ $selected == 'hour_base' ? 'selected' : '' }} >Hour base</option>
            <option value="kwh_base" {{ $selected == 'kwh_base' ? 'selected' : '' }} >kWh base</option>
            <option value="parking_base" {{ $selected == 'parking_base' ? 'selected' : '' }} >Parking base</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="parking" label="Parking">
            @php $selected = old('parking', ($editing ? $chargerLocation->parking : '')) @endphp
            <option value="yes" {{ $selected == 'yes' ? 'selected' : '' }} >Yes</option>
            <option value="no" {{ $selected == 'no' ? 'selected' : '' }} >No</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="coordinate"
            label="Coordinate"
            :value="old('coordinate', ($editing ? $chargerLocation->coordinate : ''))"
            maxlength="100"
            placeholder="Coordinate"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.url
            name="maps"
            label="Maps"
            :value="old('maps', ($editing ? $chargerLocation->maps : ''))"
            maxlength="255"
            placeholder="Maps"
        ></x-inputs.url>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $chargerLocation->status : 'not verified')) @endphp
            <option value="verified" {{ $selected == 'verified' ? 'selected' : '' }} >Verified</option>
            <option value="not verified" {{ $selected == 'not verified' ? 'selected' : '' }} >Not verified</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $chargerLocation->description :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $chargerLocation->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    @livewire('selects.province-id-city-id-dependent-select', ['chargerLocation'
    => $editing ? $chargerLocation->id : null])
</div>
