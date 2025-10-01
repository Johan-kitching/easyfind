<div class="flex flex-wrap p-5 gap-4 justify-center">
    <div id="currentLocation">
{{--        {{$current_location}}--}}

    </div>
    <div class="flex items-end w-full">
        @if(!is_null($types))
{{--            @dump($results->count())--}}
        <div class="w-fit min-w-40">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="id" option-label="name" label="Type" :clearable="false" x-on:focus="checkLocationSearchSettings()" placeholder="All"/>
        </div>
        @endif
        <div class="w-full">
            <x-input placeholder="search" wire:model.live.debounce.300ms="search" x-on:click="checkLocationSearchSettings()">
                <x-slot name="append">
                    <x-button
                        class="h-full"
                        icon="magnifying-glass"
                        rounded="rounded-r-md"
                        primary
                    />
                </x-slot>
            </x-input>
        </div>
    </div>

    <div id="results" class="flex flex-wrap p-5 gap-4 justify-center min-h-[300px] content-center" wire:key="Results">
        @if(!is_null($results))
            @forelse($results as $result)
                    <livewire:transporter-result :transporter="$result->id" :distance="$result->distance" wire:key="{{'transporter'.$type.$result->id}}"/>
            @empty
                Please redefine your search.
            @endforelse
        @endif
    </div>
    @script
    <script language="JavaScript">

        let id;
        let target;
        let options;

        function success(pos) {
            @this.
            set('current_location', "Your Shared Location is: " + pos.coords.latitude + ", " + pos.coords.longitude);
            @this.
            set('current_latitude', pos.coords.latitude);
            @this.
            set('current_longitude', pos.coords.longitude);
        }

        function error(err) {
            console.error(`ERROR(${err.code}): ${err.message}`);
            @this.
            set('current_location', "Using {{$city}} as your current location");
        }

        target = {
            latitude: 0,
            longitude: 0,
        };

        options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        };

        window.checkLocationSearchSettings = function () {
            if (@this.get('current_latitude') == null)
            {
                id = navigator.geolocation.watchPosition(success, error, options);
            }
            navigator.geolocation.watchPosition(success, error, options);
        };
    </script>
    @endscript
</div>
