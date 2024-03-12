<div>
    <div>
        @can('create', App\Models\SubMerkVehicle::class)
        <button class="button" wire:click="newSubMerkVehicle">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\SubMerkVehicle::class)
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
                        <x-inputs.select
                            name="subMerkVehicle.merk_vehicle_id"
                            label="Merk Vehicle"
                            wire:model="subMerkVehicle.merk_vehicle_id"
                        >
                            <option value="null" disabled>Please select the Merk Vehicle</option>
                            @foreach($merkVehiclesForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="subMerkVehicle.sub_merk"
                            label="Sub Merk"
                            wire:model="subMerkVehicle.sub_merk"
                            maxlength="30"
                            placeholder="Sub Merk"
                        ></x-inputs.text>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="subMerkVehicle.battery_capacity"
                            label="Battery Capacity"
                            wire:model="subMerkVehicle.battery_capacity"
                            max="255"
                            step="0.01"
                            placeholder="Battery Capacity"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="subMerkVehicle.charger_type_id"
                            label="Charger Type"
                            wire:model="subMerkVehicle.charger_type_id"
                        >
                            <option value="null" disabled>Please select the Charger Type</option>
                            @foreach($chargerTypesForSelect as $value => $label)
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
                        @lang('crud.type_vehicle_sub_merk_vehicles.inputs.merk_vehicle_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.type_vehicle_sub_merk_vehicles.inputs.sub_merk')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.type_vehicle_sub_merk_vehicles.inputs.battery_capacity')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.type_vehicle_sub_merk_vehicles.inputs.charger_type_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($subMerkVehicles as $subMerkVehicle)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $subMerkVehicle->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($subMerkVehicle->merkVehicle)->merk ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $subMerkVehicle->sub_merk ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $subMerkVehicle->battery_capacity ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($subMerkVehicle->chargerType)->name ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $subMerkVehicle)
                            <button
                                type="button"
                                class="button"
                                wire:click="editSubMerkVehicle({{ $subMerkVehicle->id }})"
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
                    <td colspan="5">
                        <div class="mt-10 px-4">
                            {{ $subMerkVehicles->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
