<div class="flex flex-wrap p-5 gap-4 justify-center">
    <div id="currentLocation">
{{--        {{$current_location}}--}}

    </div>
    <div class="flex items-end w-full">
        @if(!is_null($types))
{{--            @dump($results->count())--}}
        <div class="w-fit min-w-40">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="id" option-label="name" label="Type" :clearable="false" placeholder="All"/>
        </div>
        @endif
        <div class="w-full">
            <x-input placeholder="search" wire:model.live.debounce.300ms="search">
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

        let target;
        let options;
        let watchId;

        function success(pos) {
            @this.setUserLocation(pos.coords.latitude, pos.coords.longitude);
        }

        function error(err) {
            console.error(`ERROR(${err.code}): ${err.message}`);
            // Check if we already have a fallback location message set
            if (!@this.get('current_location') || @this.get('current_location').includes('Using')) {
                 @this.set('current_location', "Using {{$city}} as your current location");
            }
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

        // Start watching immediately
        document.addEventListener('livewire:initialized', () => {
             if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(success, error, options);
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        });
    </script>
    @endscript
</div>
