<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.charger_locations.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('charger-locations.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $chargerLocation->image ? \Storage::url($chargerLocation->image) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.name')
                        </h5>
                        <span>{{ $chargerLocation->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.provider_id')
                        </h5>
                        <span
                            >{{ optional($chargerLocation->provider)->name ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.location_on')
                        </h5>
                        <span>{{ $chargerLocation->location_on ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.system')
                        </h5>
                        <span>{{ $chargerLocation->system ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.parking')
                        </h5>
                        <span>{{ $chargerLocation->parking ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.coordinate')
                        </h5>
                        <span>{{ $chargerLocation->coordinate ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.maps')
                        </h5>
                        <a
                            class="underline cursor-pointer"
                            target="_blank"
                            href="{{ $chargerLocation->maps }}"
                            >{{ $chargerLocation->maps ?? '-' }}</a
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.status')
                        </h5>
                        <span>{{ $chargerLocation->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.description')
                        </h5>
                        <span>{{ $chargerLocation->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.user_id')
                        </h5>
                        <span
                            >{{ optional($chargerLocation->user)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.province_id')
                        </h5>
                        <span
                            >{{ optional($chargerLocation->province)->province
                            ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charger_locations.inputs.city_id')
                        </h5>
                        <span
                            >{{ optional($chargerLocation->city)->city ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('charger-locations.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ChargerLocation::class)
                    <a
                        href="{{ route('charger-locations.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Charger::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Chargers </x-slot>

                <livewire:charger-location-chargers-detail
                    :chargerLocation="$chargerLocation"
                />
            </x-partials.card>
            @endcan @can('view-any', App\Models\Charge::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Charges </x-slot>

                <livewire:charger-location-charges-detail
                    :chargerLocation="$chargerLocation"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
