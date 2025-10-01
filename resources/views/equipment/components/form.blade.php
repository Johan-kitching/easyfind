<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="make" name="make" wire:model.live="make" :options="$makes" option-value="make" option-label="make" label="Make"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="variant" name="variant" wire:model.live="variant" :options="$variants" option-value="id" option-label="variant" label="Model"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="location" name="location" wire:model.live="location" :options="$locations" option-value="id" option-label="address" label="Location"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="operator" name="operator" wire:model.live="operator" :options="$operators" option-value="id" option-label="memberName" label="Operator"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-textarea id="description" name="description" wire:model.live="description" label="Description" placeholder="Please provide a complete and full description of you vehicle."/>
        </div>
    </div>
    <div wire:loading wire:target="upload">Uploading...</div>
    <div class="mt-4 w-full">
        <x-livewire-filepond wire:model="photos" accept="image/*" label="Photos" allowImagePreview multiple/>
        @error('photos')
        <div class="text-sm font-medium text-negative-600">{{ $message }}</div>
        @enderror
    </div>
</div>
