<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="category" name="category" wire:model.live="category" :options="$categories" option-value="category" option-label="category" label="Category"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="id" option-label="type" label="Type"/>
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
    <div x-show="submitButtonDisabled!=0"  x-transition><x-loader class="text-white" color="#093c78" bordercolor="rgb(255 255 255 / 5%)" border="1px">Uploading</x-loader></div>
    <div class="mt-4 w-full">
        <x-livewire-filepond wire:model="photos" accept="image/*" label="Photos" allowImagePreview multiple/>
        @error('photos')
        <div class="text-sm font-medium text-negative-600">{{ $message }}</div>
        @enderror
    </div>
</div>
