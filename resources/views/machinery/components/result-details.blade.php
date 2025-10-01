<x-card title="{{$machinery->category}} - {{$machinery->type}}" rounded="3xl" shadow="2xl" class="hover:shadow-none" x-data="{mainUrl:'{{$machinery->photos->first()->fullPath}}'}">
    <div>
        <div>
            <div class="shrink-0 inline-flex items-center justify-center overflow-hidden border-secondary-200 dark:border-secondary-500 bg-secondary-300 dark:bg-secondary-600 border w-64 h-64 rounded-[1.25rem]" id="MainImage" xl="xl">
                <img class="w-full h-full object-cover" alt="Machinery Image" x-bind:src="mainUrl">
            </div>
            {{--            <x-avatar id="MainImage" xl rounded="rounded-[1.25rem]" x-bind:src="mainUrl" size="w-64 h-64"/>--}}
            <div id="SmallImage">
                @foreach($machinery->photos as $photo)
                    <x-avatar xl rounded="rounded-[0.25rem]" :src="$photo->fullPath" size="w-5 h-5" class="hover:drop-shadow-md cursor-pointer hover:border hover:border-white hover:dark:border-black" @click="mainUrl='{{$photo->fullPath}}'"/>
                @endforeach
            </div>
        </div>
        <div class="text-xs justify-center grid">{{Str::of($machinery->address)->words(5, ' ...')}}</div>
    </div>
    <x-slot name="footer" class="flex items-start justify-end text-blue-500">
        {{round($machinery->distance,2)}}Km away
        <x-button wire:click="confirmLogout" wire:loading.attr="disabled">
            {{ __('Log Out Browser Sessions') }}
        </x-button>
    </x-slot>
</x-card>
