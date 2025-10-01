<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="id" option-label="name" label="Type"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-label>Current Location</x-label>
            <div class="text-xs text-gray-700 dark:text-gray-400 font-thin"><span class="font-bold">Address:</span> {{$address}}</div>
            <div class="text-xs text-gray-700 dark:text-gray-400"><span class="font-bold">City:</span> {{$city}}</div>
            <div class="text-xs text-gray-700 dark:text-gray-400"><span class="font-bold">Latitude:</span> {{$address_latitude}}</div>
            <div class="text-xs text-gray-700 dark:text-gray-400"><span class="font-bold">Longitude:</span> {{$address_longitude}}</div>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="location" name="location" wire:model.live="location" :options="$locations" option-value="id" option-label="address" label="Location"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="operator" name="operator" wire:model.live="operator" :options="$operators" option-value="id" option-label="name" label="Operator"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-textarea id="description" name="description" wire:model.live="description" label="Description" placeholder="Please provide a complete and full description of you vehicle."/>
        </div>
    </div>
    <div class="mt-4 w-full">
        <x-livewire-filepond wire:model="photos" accept="image/*" label="Photos" allowImagePreview multiple/>
        @error('photos')
        <div class="text-sm font-medium text-negative-600">{{ $message }}</div>
        @enderror
        <div class="grid grid-cols-2 gap-4 place-content-center">

            @foreach($photosLoaded as $image)
                <div
                    class="m-4 p-1 rounded border-solid border-current border text-center shadow-xl hover:shadow-none grid place-content-center">
                    <img src="{{$image->fullPath}}"
                         class="w-52 place-self-center">
                    <br>
                    <div x-data="{ title: 'Sure Delete?' }">
                        @if(count($photosLoaded) <= 1)
                            <x-label>At least one image is required. Please add a new image before removing this one.</x-label>
                        @else
                            <x-button warning label="Delete" wire:click="confirmRemove('{{$image->id}}')"/>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div x-show="submitButtonDisabled!=0"  x-transition><x-loader class="text-white" color="#093c78" bordercolor="rgb(255 255 255 / 5%)" border="1px">Uploading</x-loader></div>
</div>
