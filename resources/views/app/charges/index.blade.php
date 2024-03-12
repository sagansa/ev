<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.charges.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Charge::class)
                            <a
                                href="{{ route('charges.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.image')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.vehicle_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.date')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.battery_start_charging')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.battery_finish_charging')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.battery_finish_before')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.km_now')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.km_before')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.parking')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.kWh')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.PPJ')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.PPN')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.admin_cost')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.charges.inputs.total_cost')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.charger_location_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.charger_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charges.inputs.user_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($charges as $charge)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $charge->image ? \Storage::url($charge->image) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charge->vehicle)->image ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $charge->date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $charge->battery_start_charging ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $charge->battery_finish_charging ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $charge->battery_finish_before ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $charge->km_now ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $charge->km_before ?? '-' }}
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
                                    {{ optional($charge->chargerLocation)->name
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charge->charger)->power ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charge->user)->name ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $charge)
                                        <a
                                            href="{{ route('charges.edit', $charge) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $charge)
                                        <a
                                            href="{{ route('charges.show', $charge) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $charge)
                                        <form
                                            action="{{ route('charges.destroy', $charge) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="18">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="18">
                                    <div class="mt-10 px-4">
                                        {!! $charges->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
