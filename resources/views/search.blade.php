<x-app-layout>
    <div class="pb-12 pt-2.5 opacity-90">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="border-secondary-200 dark:border-secondary-600 px-4 py-2.5 flex justify-between items-center rounded-t-lg border-b bg-white dark:bg-gray-700">
                    <div class="font-medium text-base whitespace-normal text-secondary-700 dark:text-secondary-400">
                        @if(request()->routeIs('search.machinery'))
                            Search Machinery
                        @elseif(request()->routeIs('search.mechanic'))
                            Search Mechanic
                        @elseif(request()->routeIs('search.transporter'))
                            Search Transporter
                        @endif
                    </div>
                </div>
                @if(request()->routeIs('search.machinery'))
                    <livewire:machinery.search-machinery/>
                @elseif(request()->routeIs('search.mechanic'))
                    <livewire:mechanic.search-mechanic/>
                @elseif(request()->routeIs('search.transporter'))
                    <livewire:transporter.search-transporter/>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
