<div>
    <div>
        @can('create', App\Models\ElectricCurrent::class)
        <button class="button" wire:click="newElectricCurrent">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.attach')
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
                            name="electric_current_id"
                            label="Electric Current"
                            wire:model="electric_current_id"
                        >
                            <option value="null" disabled>Please select the Electric Current</option>
                            @foreach($electricCurrentsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="Max_charge_capacity"
                            label="Max Charge Capacity"
                            wire:model="Max_charge_capacity"
                            maxlength="255"
                            placeholder="Max Charge Capacity"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="charging_percentage"
                            label="Charging Percentage"
                            wire:model="charging_percentage"
                            maxlength="20"
                            placeholder="Charging Percentage"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="charging_time"
                            label="Charging Time"
                            wire:model="charging_time"
                            maxlength="20"
                            placeholder="Charging Time"
                        ></x-inputs.text>
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
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sub_merk_vehicle_electric_currents.inputs.electric_current_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sub_merk_vehicle_electric_currents.inputs.Max_charge_capacity')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sub_merk_vehicle_electric_currents.inputs.charging_percentage')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sub_merk_vehicle_electric_currents.inputs.charging_time')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($subMerkVehicleElectricCurrents as $electricCurrent)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        {{ $electricCurrent->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $electricCurrent->pivot->Max_charge_capacity ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $electricCurrent->pivot->charging_percentage ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $electricCurrent->pivot->charging_time ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 70px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('delete-any',
                            App\Models\ElectricCurrent::class)
                            <button
                                class="button button-danger"
                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                wire:click="detach('{{ $electricCurrent->id }}')"
                            >
                                <i
                                    class="mr-1 icon ion-md-trash text-primary"
                                ></i>
                                @lang('crud.common.detach')
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
                            {{ $subMerkVehicleElectricCurrents->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
