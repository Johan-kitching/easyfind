<x-card title="{{$mechanic->name}} - {{$mechanic->type->name}}" rounded="3xl" shadow="2xl" class="hover:shadow-none">
    <div style="height: 256px; width: 256px;">@if($unavailable->count()>=1)
            <div class="absolute w-64 h-64 flex items-end justify-center text-center">
                <span class="text-white text-2xl font-bold bg-red-500 opacity-75 w-full rounded-b-[1.25rem] text-sm m-[1px]">Unavailable until {{ \Carbon\Carbon::parse($unavailable->max('end_date'))->format('Y-m-d') }}</span>
            </div>
        @endif
        Description:
        {!! $mechanic->description !!}

    </div>
    <x-slot name="footer" class="flex gap-4 items-start justify-end text-blue-500 place-content-between place-items-center" style="place-content: space-between; place-items: center;">
        <div>{{round($distance,2)}}Km away</div>
        <x-button wire:click="dispatch('openModal', {component: 'Mechanic.view', arguments: {{ json_encode([$mechanic->id]) }} })">
            {{ __('View') }}
        </x-button>
    </x-slot>
</x-card>
