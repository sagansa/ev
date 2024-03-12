<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.state_of_healths.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('state-of-healths.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $stateOfHealth->image ? \Storage::url($stateOfHealth->image) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.vehicle_id')
                        </h5>
                        <span
                            >{{ optional($stateOfHealth->vehicle)->image ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.km')
                        </h5>
                        <span>{{ $stateOfHealth->km ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.percentage')
                        </h5>
                        <span>{{ $stateOfHealth->percentage ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.how_to_charge')
                        </h5>
                        <span>{{ $stateOfHealth->how_to_charge ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.status')
                        </h5>
                        <span>{{ $stateOfHealth->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.state_of_healths.inputs.user_id')
                        </h5>
                        <span
                            >{{ optional($stateOfHealth->user)->name ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('state-of-healths.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\StateOfHealth::class)
                    <a
                        href="{{ route('state-of-healths.create') }}"
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
