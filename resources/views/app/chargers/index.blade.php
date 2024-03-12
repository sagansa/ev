<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.chargers.index_title')
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
                            @can('create', App\Models\Charger::class)
                            <a
                                href="{{ route('chargers.create') }}"
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
                                    @lang('crud.chargers.inputs.charger_location_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.charger_type_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.electric_current_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.power')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.chargers.inputs.unit')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.chargers.inputs.charge_cost')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.chargers.inputs.PPJ')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.chargers.inputs.admin_cost')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.PPN')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.status')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.chargers.inputs.user_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($chargers as $charger)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charger->chargerLocation)->name
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charger->chargerType)->name ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($charger->electricCurrent)->name
                                    ?? '-' }}
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
                                        @can('update', $charger)
                                        <a
                                            href="{{ route('chargers.edit', $charger) }}"
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
                                        @endcan @can('view', $charger)
                                        <a
                                            href="{{ route('chargers.show', $charger) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $charger)
                                        <form
                                            action="{{ route('chargers.destroy', $charger) }}"
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
                                <td colspan="12">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="mt-10 px-4">
                                        {!! $chargers->render() !!}
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
