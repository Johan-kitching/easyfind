<x-card title="{{$transporter->type->name}}" rounded="3xl" shadow="2xl" class="hover:shadow-none max-w-[288px]" x-data="{mainUrl:'{{$transporter->photos?->first()?->fullPath}}'}">
    <div>
        <div>
            <div class="shrink-0 inline-flex items-center justify-center overflow-hidden border-secondary-200 dark:border-secondary-500 bg-secondary-300 dark:bg-secondary-600 border w-64 h-64 rounded-[1.25rem]" id="MainImage"
                 xl="xl">
                @if($unavailable->count()>=1)
                    <div class="absolute w-64 h-64 flex items-end justify-center text-center">
                        <span class="text-white text-2xl font-bold bg-red-500 opacity-75 w-full rounded-b-[1.25rem] text-sm m-[1px]">Unavailable until {{ \Carbon\Carbon::parse($unavailable->max('end_date'))->format('Y-m-d') }}</span>
                    </div>
                @endif
                @if($transporter->photos?->first()?->fullPath)
                    <img class="w-full h-full object-cover" alt="Machinery Image" x-bind:src="mainUrl">
                @endif
            </div>
            <div id="SmallImage" class="justify-end overflow-x-auto w-full">
                @foreach($transporter->photos as $photo)
                    <x-avatar xl rounded="rounded-[0.25rem]" :src="$photo->fullPath" size="w-5 h-5" class="mx-0.5 hover:drop-shadow-md cursor-pointer hover:border hover:border-white hover:dark:border-black"
                              @click="mainUrl='{{$photo->fullPath}}'"/>
                @endforeach
            </div>
        </div>
        <div class="text-xs justify-center grid">{{Str::of($transporter->address)->words(5, ' ...')}}</div>
    </div>
    <x-slot name="footer" class="flex gap-4 items-start justify-end text-blue-500 place-content-between place-items-center" style="place-content: space-between; place-items: center;">
        <div>{{round($transporter->distance,2)}}Km away</div>
        <x-button wire:click="dispatch('openModal', {component: 'Transporter.view', arguments: {{ json_encode([$transporter->id]) }} })">
            {{ __('View') }}
        </x-button>
    </x-slot>
</x-card>
