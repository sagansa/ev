<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.charges.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('charges.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $charge->image ? \Storage::url($charge->image) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.vehicle_id')
                        </h5>
                        <span
                            >{{ optional($charge->vehicle)->image ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.date')
                        </h5>
                        <span>{{ $charge->date ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.battery_start_charging')
                        </h5>
                        <span
                            >{{ $charge->battery_start_charging ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.battery_finish_charging')
                        </h5>
                        <span
                            >{{ $charge->battery_finish_charging ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.battery_finish_before')
                        </h5>
                        <span>{{ $charge->battery_finish_before ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.km_now')
                        </h5>
                        <span>{{ $charge->km_now ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.km_before')
                        </h5>
                        <span>{{ $charge->km_before ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.parking')
                        </h5>
                        <span>{{ $charge->parking ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.kWh')
                        </h5>
                        <span>{{ $charge->kWh ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.PPJ')
                        </h5>
                        <span>{{ $charge->PPJ ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.PPN')
                        </h5>
                        <span>{{ $charge->PPN ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.admin_cost')
                        </h5>
                        <span>{{ $charge->admin_cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.total_cost')
                        </h5>
                        <span>{{ $charge->total_cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.charger_location_id')
                        </h5>
                        <span
                            >{{ optional($charge->chargerLocation)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.charger_id')
                        </h5>
                        <span
                            >{{ optional($charge->charger)->power ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.charges.inputs.user_id')
                        </h5>
                        <span>{{ optional($charge->user)->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('charges.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Charge::class)
                    <a href="{{ route('charges.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
