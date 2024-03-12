<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sub_merk_vehicles.edit_title')
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

                <x-form
                    method="PUT"
                    action="{{ route('sub-merk-vehicles.update', $subMerkVehicle) }}"
                    class="mt-4"
                >
                    @include('app.sub_merk_vehicles.form-inputs')

                    <div class="mt-10">
                        <a
                            href="{{ route('sub-merk-vehicles.index') }}"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a
                            href="{{ route('sub-merk-vehicles.create') }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>

            @can('view-any', App\Models\ElectricCurrent::class)
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
