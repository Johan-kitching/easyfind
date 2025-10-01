<x-app-layout>
    @if(!is_null(Auth::user()))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        @if(Auth()->user()->machinery->count()>=1)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg opacity-90">
                        <div class="border-secondary-200 dark:border-secondary-600 px-4 py-2.5 flex justify-between items-center rounded-t-lg border-b bg-white dark:bg-gray-700">
                            <div class="font-medium text-base whitespace-normal text-secondary-700 dark:text-secondary-400">
                                Update Machinery Locations
                            </div>
                        </div>
                        <livewire:machinery.update-machinery-location wire:key="machineryLocation"/>
                    </div>
                </div>
            </div>
        @endif
        @if(Auth()->user()->mechanics->count()>=1)
            <div class="pb-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg opacity-90">
                        <div class="border-secondary-200 dark:border-secondary-600 px-4 py-2.5 flex justify-between items-center rounded-t-lg border-b bg-white dark:bg-gray-700">
                            <div class="font-medium text-base whitespace-normal text-secondary-700 dark:text-secondary-400">
                                Update Mechanic Locations
                            </div>
                        </div>
                        <livewire:mechanic.update-mechanic-location wire:key="mechanicLocation"/>
                    </div>
                </div>
            </div>
        @endif
        @if(Auth()->user()->transporters->count()>=1)
            <div class="pb-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg opacity-90">
                        <div class="border-secondary-200 dark:border-secondary-600 px-4 py-2.5 flex justify-between items-center rounded-t-lg border-b bg-white dark:bg-gray-700">
                            <div class="font-medium text-base whitespace-normal text-secondary-700 dark:text-secondary-400">
                                Update Transporter Locations
                            </div>
                        </div>
                        <livewire:transporter.update-transporter-location wire:key="transporterLocation"/>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="pb-12 pt-2.5 opacity-90">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="border-secondary-200 dark:border-secondary-600 px-4 py-2.5 flex justify-between items-center rounded-t-lg border-b bg-white dark:bg-gray-700">
                    <div class="font-medium text-base whitespace-normal text-secondary-700 dark:text-secondary-400">
                        Search Machinery
                    </div>
                </div>
                <livewire:machinery.search-machinery/>
            </div>
        </div>
    </div>
</x-app-layout>
