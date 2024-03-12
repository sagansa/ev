<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.vehicles.index_title')
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
                            @can('create', App\Models\Vehicle::class)
                            <a
                                href="{{ route('vehicles.create') }}"
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
                                    @lang('crud.vehicles.inputs.image')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.license_plate')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.ownership')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.type_vehicle_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.user_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.merk_vehicle_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vehicles.inputs.sub_merk_vehicle_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $vehicle->image ? \Storage::url($vehicle->image) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vehicle->license_plate ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vehicle->ownership ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($vehicle->typeVehicle)->type ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($vehicle->user)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($vehicle->merkVehicle)->merk ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($vehicle->subMerkVehicle)->sub_merk
                                    ?? '-' }}
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
                                        @can('update', $vehicle)
                                        <a
                                            href="{{ route('vehicles.edit', $vehicle) }}"
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
                                        @endcan @can('view', $vehicle)
                                        <a
                                            href="{{ route('vehicles.show', $vehicle) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $vehicle)
                                        <form
                                            action="{{ route('vehicles.destroy', $vehicle) }}"
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
                                <td colspan="8">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="mt-10 px-4">
                                        {!! $vehicles->render() !!}
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
