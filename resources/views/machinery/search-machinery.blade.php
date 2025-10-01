<div class="flex flex-wrap p-5 gap-4 justify-center">
    <div id="currentLocation">
{{--        {{$current_location}}--}}
    </div>
    <div class="flex items-end w-full">
        <div class="w-fit min-w-40">
{{--            @dump($categories)--}}
{{--            @dump($types)--}}
            <x-select id="category" name="category" wire:model.live="category" :options="$categories" option-value="category" option-label="category_count" label="Category" :clearable="false" x-on:focus="checkLocationSearchSettings()"/>
        </div>
        @if(!is_null($types))
        <div class="w-fit min-w-40">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="type" option-label="type_count" label="Type" :clearable="false" x-on:focus="checkLocationSearchSettings()"/>
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

    <div id="results" class="flex flex-wrap p-5 gap-4 justify-center min-h-[300px] content-center">
        @if(!is_null($results))
            @forelse($results as $result)
                    <livewire:machine-result :machinery="$result" wire:key="{{$category.$result->id}}"/>
            @empty
                Please redefine your search.
            @endforelse
{{--            @dump($category,$results)--}}
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
