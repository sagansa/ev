<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.trips.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('trips.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.vehicle_id')
                        </h5>
                        <span
                            >{{ optional($trip->vehicle)->image ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.user_id')
                        </h5>
                        <span>{{ optional($trip->user)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.from')
                        </h5>
                        <span>{{ $trip->from ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.coordinate_from')
                        </h5>
                        <span>{{ $trip->coordinate_from ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.to')
                        </h5>
                        <span>{{ $trip->to ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.coordinate_to')
                        </h5>
                        <span>{{ $trip->coordinate_to ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('trips.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Trip::class)
                    <a href="{{ route('trips.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\DetailTrip::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Detail Trips </x-slot>

                <livewire:trip-detail-trips-detail :trip="$trip" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
