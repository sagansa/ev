<div>
    <div>
        @can('create', App\Models\Charge::class)
        <button class="button" wire:click="newCharge">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Charge::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <div
                            image-url="{{ $editing && $charge->image ? \Storage::url($charge->image) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="chargeImage"
                                label="Image"
                            ></x-inputs.partials.label
                            ><br />

                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="chargeImage"
                                    id="chargeImage{{ $uploadIteration }}"
                                    wire:model="chargeImage"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('chargeImage')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charge.vehicle_id"
                            label="Vehicle"
                            wire:model="charge.vehicle_id"
                        >
                            <option value="null" disabled>Please select the Vehicle</option>
                            @foreach($vehiclesForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="chargeDate"
                            label="Date"
                            wire:model="chargeDate"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charge.charger_id"
                            label="Charger"
                            wire:model="charge.charger_id"
                        >
                            <option value="null" disabled>Please select the Charger</option>
                            @foreach($chargersForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.km_now"
                            label="km Now"
                            wire:model="charge.km_now"
                            placeholder="km Now"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.km_before"
                            label="km Before"
                            wire:model="charge.km_before"
                            placeholder="km Before"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.battery_start_charging"
                            label="Battery Start Charging"
                            wire:model="charge.battery_start_charging"
                            max="100"
                            placeholder="Battery Start Charging"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.battery_finish_charging"
                            label="Battery Finish Charging"
                            wire:model="charge.battery_finish_charging"
                            max="100"
                            placeholder="Battery Finish Charging"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.battery_finish_before"
                            label="Battery Finish Before"
                            wire:model="charge.battery_finish_before"
                            max="100"
                            placeholder="Battery Finish Before"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.parking"
                            label="Parking"
                            wire:model="charge.parking"
                            placeholder="Parking"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.kWh"
                            label="kWh"
                            wire:model="charge.kWh"
                            placeholder="kWh"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.PPJ"
                            label="PPJ"
                            wire:model="charge.PPJ"
                            placeholder="PPJ"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.PPN"
                            label="PPN"
                            wire:model="charge.PPN"
                            placeholder="PPN"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.admin_cost"
                            label="Admin Cost"
                            wire:model="charge.admin_cost"
                            placeholder="Admin Cost"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charge.total_cost"
                            label="Total Cost"
                            wire:model="charge.total_cost"
                            placeholder="Total Cost"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charge.user_id"
                            label="User"
                            wire:model="charge.user_id"
                        >
                            <option value="null" disabled>Please select the User</option>
                            @foreach($usersForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_charges.inputs.image')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_charges.inputs.vehicle_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_charges.inputs.date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_charges.inputs.charger_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.km_now')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.km_before')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.battery_start_charging')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.battery_finish_charging')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.battery_finish_before')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.parking')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.kWh')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.PPJ')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.PPN')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.admin_cost')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_charges.inputs.total_cost')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_charges.inputs.user_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($charges as $charge)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $charge->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        <x-partials.thumbnail
                            src="{{ $charge->image ? \Storage::url($charge->image) : '' }}"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charge->vehicle)->image ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $charge->date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charge->charger)->power ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->km_now ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->km_before ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->battery_start_charging ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->battery_finish_charging ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->battery_finish_before ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->parking ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->kWh ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->PPJ ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->PPN ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->admin_cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charge->total_cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charge->user)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $charge)
                            <button
                                type="button"
                                class="button"
                                wire:click="editCharge({{ $charge->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="17">
                        <div class="mt-10 px-4">{{ $charges->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
