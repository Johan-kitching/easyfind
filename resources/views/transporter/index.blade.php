<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Transporter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-visible bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-1 text-center">
                @can('My Transporter - Add')
                    @if(Auth::user()->getCanAddAssetsAttribute())
                    <div class="w-full text-center p-1">
                        <x-button outline primary class="dark:text-gray-400 hover:dark:text-white"
                                  onclick="Livewire.dispatch('openModal', {component: 'Transporter.Create'})">
                            <x-icon name="plus" class="w-5 h-5"/>
                            Add Transporter
                        </x-button>
                    </div>
                    @else
                        <div class="w-full text-center p-1">
                            <a href="{{route('payments')}}">Update your package to add more transporters. <span class="text-blue-600 hover:text-blue-800"> Click Here.</span></a>
                        </div>
                    @endif
                        <div><span class="font-bold">Assets Remaining:</span> {{ Auth::user()->getAssetsRemainingAttribute() }} / {{Auth::user()->package->assets}}</div>
                @endcan
                <livewire:transporter.transporter-table :url="request()->url()"/>
            </div>
        </div>
    </div>
</x-app-layout>
