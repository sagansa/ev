<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.charger_locations.index_title')
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
                            @can('create', App\Models\ChargerLocation::class)
                            <a
                                href="{{ route('charger-locations.create') }}"
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
                                    @lang('crud.charger_locations.inputs.image')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.provider_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.location_on')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.system')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.parking')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.coordinate')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.status')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.user_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.province_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.charger_locations.inputs.city_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($chargerLocations as $chargerLocation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $chargerLocation->image ? \Storage::url($chargerLocation->image) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($chargerLocation->provider)->name
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->location_on ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->system ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->parking ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->coordinate ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $chargerLocation->status ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($chargerLocation->user)->name ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($chargerLocation->province)->province
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($chargerLocation->city)->city ??
                                    '-' }}
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
                                        @can('update', $chargerLocation)
                                        <a
                                            href="{{ route('charger-locations.edit', $chargerLocation) }}"
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
                                        @endcan @can('view', $chargerLocation)
                                        <a
                                            href="{{ route('charger-locations.show', $chargerLocation) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $chargerLocation)
                                        <form
                                            action="{{ route('charger-locations.destroy', $chargerLocation) }}"
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
                                        {!! $chargerLocations->render() !!}
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
