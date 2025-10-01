<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-visible bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-1">
                @can('Users - Create')
                    <div class="w-full text-center p-1">
                        <x-button outline primary class="dark:text-gray-400 hover:dark:text-white"
                                  onclick="Livewire.dispatch('openModal', {component: 'Admin.Users.CreateUser'})">
                            <x-icon name="plus" class="w-5 h-5"/>
                            New User
                        </x-button>
                    </div>
                @endcan
                <livewire:user-table/>
            </div>
        </div>
    </div>
</x-app-layout>
