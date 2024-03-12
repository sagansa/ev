<div>
    <div>
        @can('create', App\Models\Charger::class)
        <button class="button" wire:click="newCharger">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Charger::class)
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
                            name="charger.charger_type_id"
                            label="Charger Type"
                            wire:model="charger.charger_type_id"
                        >
                            <option value="null" disabled>Please select the Charger Type</option>
                            @foreach($chargerTypesForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charger.electric_current_id"
                            label="Electric Current"
                            wire:model="charger.electric_current_id"
                        >
                            <option value="null" disabled>Please select the Electric Current</option>
                            @foreach($electricCurrentsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="charger.power"
                            label="Power"
                            wire:model="charger.power"
                            maxlength="10"
                            placeholder="Power"
                        ></x-inputs.text>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charger.unit"
                            label="Unit"
                            wire:model="charger.unit"
                            min="1"
                            placeholder="Unit"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charger.charge_cost"
                            label="Charge Cost"
                            wire:model="charger.charge_cost"
                            placeholder="Charge Cost"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charger.PPJ"
                            label="PPJ"
                            wire:model="charger.PPJ"
                            placeholder="PPJ"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="charger.admin_cost"
                            label="Admin Cost"
                            wire:model="charger.admin_cost"
                            placeholder="Admin Cost"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charger.PPN"
                            label="PPN"
                            wire:model="charger.PPN"
                        >
                            <option value="yes" {{ $selected == 'yes' ? 'selected' : '' }} >Yes</option>
                            <option value="no" {{ $selected == 'no' ? 'selected' : '' }} >No</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charger.status"
                            label="Status"
                            wire:model="charger.status"
                        >
                            <option value="verified" {{ $selected == 'verified' ? 'selected' : '' }} >Verified</option>
                            <option value="not verified" {{ $selected == 'not verified' ? 'selected' : '' }} >Not verified</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="charger.user_id"
                            label="User"
                            wire:model="charger.user_id"
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
                        @lang('crud.charger_location_chargers.inputs.charger_type_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_chargers.inputs.electric_current_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_chargers.inputs.power')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_chargers.inputs.unit')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_chargers.inputs.charge_cost')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_chargers.inputs.PPJ')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.charger_location_chargers.inputs.admin_cost')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_chargers.inputs.PPN')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_chargers.inputs.status')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.charger_location_chargers.inputs.user_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($chargers as $charger)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $charger->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charger->chargerType)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charger->electricCurrent)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $charger->power ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charger->unit ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charger->charge_cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charger->PPJ ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $charger->admin_cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $charger->PPN ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $charger->status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($charger->user)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $charger)
                            <button
                                type="button"
                                class="button"
                                wire:click="editCharger({{ $charger->id }})"
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
                    <td colspan="11">
                        <div class="mt-10 px-4">{{ $chargers->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
