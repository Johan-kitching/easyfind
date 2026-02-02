<div class="flex flex-wrap p-5 gap-4 justify-center">
    <div id="currentLocation">
        Current Location: {{$current_location}}
    </div>
    <div class="flex items-end w-full">
        <div class="w-fit min-w-40">
{{--            @dump($categories)--}}
{{--            @dump($types)--}}
            <x-select id="category" name="category" wire:model.live="category" :options="$categories" option-value="category" option-label="category_count" label="Category" :clearable="false" />
        </div>
        @if(!is_null($types))
        <div class="w-fit min-w-40">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="type" option-label="type_count" label="Type" :clearable="false" />
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
