<x-app-layout>
    @if(!is_null(Auth::user()))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Subscription') }} {{$userPackage}}
            </h2>
        </x-slot>
    @endif

    <div class="pb-12 pt-2.5 opacity-90">
        <x-card class="w-fit bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4 place-self-center">
            @if(Auth::user()->payments?->last()?->created_at->format('d M Y'))
                <div class="w-fit text-center p-1 place-items-center place-self-center">
                    <div class="grid grid-cols-2 gap-3 text-left">
                        <div><span class="font-bold">Last Payment:</span> {{ Auth::user()->payments?->last()?->created_at->format('d M Y') }}</div>
                        <div><span class="font-bold">Amount:</span> R{{ Auth::user()->package?->price }}</div>
                        <div><span class="font-bold">Current Assets:</span> {{ Auth::user()->getMyAssetsCountAttribute() }}</div>
                        <div><span class="font-bold">Assets Remaining:</span> {{ Auth::user()->getAssetsRemainingAttribute() }} / {{Auth::user()->package->assets}}</div>
                        <div><span class="font-bold">Machinery:</span> {{ Auth::user()->machinery->count()}}</div>
                        <div><span class="font-bold">Mechanics:</span> {{ Auth::user()->mechanics->count()}}</div>
                        <div><span class="font-bold">Transporters:</span> {{ Auth::user()->transporters->count()}}</div>
                        <div><span class="font-bold">Subscription Status:</span> {{ Auth::user()->getHasActiveSubscriptionAttribute()?'Active':'Inactive'}}</div>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-3 gap-3 items-center">
                @foreach($packages as $package)
                    <x-card class="w-full max-w-sm bg-gray-200! dark:bg-gray-800 shadow-md rounded-lg p-4 m-4 cursor-pointer">
                        <div class="flex items-center">
                            <div class="ml-4 w-full">
                                @if($package->id==$userPackage)
                                    @if(Auth::user()->getHasActiveSubscriptionAttribute())
                                        <p class="bg-green-500 rounded-full float-right">
                                            <x-icon name="check" class="w-6 h-6 text-white"/>
                                        </p>
                                    @else
                                        <p class="bg-red-500 rounded-full float-right">
                                            <x-icon name="x-mark" class="w-6 h-6 text-white"/>
                                        </p>
                                    @endif
                                @endif
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $package->name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $package->assets }}x Assets</p>
                                <p class="text-gray-800 dark:text-gray-200 font-bold text-xl w-full text-right">R{{ $package->price }}</p>
                            </div>
                        </div>
                        @if($package->id!=$userPackage)
                            <x-button label="Select / Change" onclick="Livewire.dispatch('openModal', {component: 'User.Subscription', arguments: {{ json_encode([$package->id]) }} })"/>
                        @else
                            <x-button label="Update" secondary onclick="Livewire.dispatch('openModal', {component: 'User.Subscription', arguments: {{ json_encode([$package->id]) }} })"/>
                        @endif
                    </x-card>
                @endforeach
            </div>
        </x-card>
    </div>
</x-app-layout>
