<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.fuel_oil_costs.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('fuel-oil-costs.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.vehicle_id')
                        </h5>
                        <span
                            >{{ optional($fuelOilCost->vehicle)->image ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.date')
                        </h5>
                        <span>{{ $fuelOilCost->date ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.fuel_price')
                        </h5>
                        <span>{{ $fuelOilCost->fuel_price ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.km_start')
                        </h5>
                        <span>{{ $fuelOilCost->km_start ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.km_end')
                        </h5>
                        <span>{{ $fuelOilCost->km_end ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.fuel_oil_costs.inputs.user_id')
                        </h5>
                        <span
                            >{{ optional($fuelOilCost->user)->name ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('fuel-oil-costs.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\FuelOilCost::class)
                    <a
                        href="{{ route('fuel-oil-costs.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
