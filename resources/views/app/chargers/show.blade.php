<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.chargers.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('chargers.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.charger_location_id')
                        </h5>
                        <span
                            >{{ optional($charger->chargerLocation)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.charger_type_id')
                        </h5>
                        <span
                            >{{ optional($charger->chargerType)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.electric_current_id')
                        </h5>
                        <span
                            >{{ optional($charger->electricCurrent)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.power')
                        </h5>
                        <span>{{ $charger->power ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.unit')
                        </h5>
                        <span>{{ $charger->unit ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.charge_cost')
                        </h5>
                        <span>{{ $charger->charge_cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.PPJ')
                        </h5>
                        <span>{{ $charger->PPJ ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.admin_cost')
                        </h5>
                        <span>{{ $charger->admin_cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.PPN')
                        </h5>
                        <span>{{ $charger->PPN ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.status')
                        </h5>
                        <span>{{ $charger->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.chargers.inputs.user_id')
                        </h5>
                        <span>{{ optional($charger->user)->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('chargers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Charger::class)
                    <a href="{{ route('chargers.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Charge::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Charges </x-slot>

                <livewire:charger-charges-detail :charger="$charger" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
