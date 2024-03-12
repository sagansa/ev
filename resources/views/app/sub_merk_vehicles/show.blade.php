<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sub_merk_vehicles.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('sub-merk-vehicles.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.sub_merk_vehicles.inputs.type_vehicle_id')
                        </h5>
                        <span
                            >{{ optional($subMerkVehicle->typeVehicle)->type ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.sub_merk_vehicles.inputs.merk_vehicle_id')
                        </h5>
                        <span
                            >{{ optional($subMerkVehicle->merkVehicle)->merk ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.sub_merk_vehicles.inputs.sub_merk')
                        </h5>
                        <span>{{ $subMerkVehicle->sub_merk ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.sub_merk_vehicles.inputs.battery_capacity')
                        </h5>
                        <span
                            >{{ $subMerkVehicle->battery_capacity ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.sub_merk_vehicles.inputs.charger_type_id')
                        </h5>
                        <span
                            >{{ optional($subMerkVehicle->chargerType)->name ??
                            '-' }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('sub-merk-vehicles.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\SubMerkVehicle::class)
                    <a
                        href="{{ route('sub-merk-vehicles.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any',
            App\Models\electric_current_sub_merk_vehicle::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Electric Currents </x-slot>

                <livewire:sub-merk-vehicle-electric-currents-detail
                    :subMerkVehicle="$subMerkVehicle"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
