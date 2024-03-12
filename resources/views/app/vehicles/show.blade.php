<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.vehicles.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('vehicles.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $vehicle->image ? \Storage::url($vehicle->image) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.license_plate')
                        </h5>
                        <span>{{ $vehicle->license_plate ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.ownership')
                        </h5>
                        <span>{{ $vehicle->ownership ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.type_vehicle_id')
                        </h5>
                        <span
                            >{{ optional($vehicle->typeVehicle)->type ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.user_id')
                        </h5>
                        <span>{{ optional($vehicle->user)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.merk_vehicle_id')
                        </h5>
                        <span
                            >{{ optional($vehicle->merkVehicle)->merk ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.vehicles.inputs.sub_merk_vehicle_id')
                        </h5>
                        <span
                            >{{ optional($vehicle->subMerkVehicle)->sub_merk ??
                            '-' }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('vehicles.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Vehicle::class)
                    <a href="{{ route('vehicles.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
