<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-visible bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-1">
                @can('My Equipment - Add')
                    <div class="w-full text-center p-1">
                        <x-button outline primary class="dark:text-gray-400 hover:dark:text-white"
                                  onclick="Livewire.dispatch('openModal', {component: 'Equipment.Create'})">
                            <x-icon name="plus" class="w-5 h-5"/>
                            Add Equipment
                        </x-button>
                    </div>
                @endcan
                <livewire:equipment.equipment-table/>
            </div>
        </div>
    </div>
</x-app-layout>
