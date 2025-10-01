<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-input name="name" label="Name" type="text" wire:model.live="name"/>
        </div>
        <div class="mt-4 w-full">
            <x-input name="assets" label="Assets" type="text" placeholder="0" wire:model.live="assets" suffix="Assets" type="number"/>
        </div>
        <div class="mt-4 w-full">
            <x-input name="price" label="Price" type="text" placeholder="0.00" wire:model.live="price" prefix="R" type="number"/>
        </div>
    </div>
</div>
