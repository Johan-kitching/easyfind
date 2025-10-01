<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-select id="category" name="category" wire:model="category" :options="$categories" option-value="category" option-label="category" label="Category">
                <x-slot name="beforeOptions">
                    <x-input id="model" name="model" wire:model="newCategory" label="Create new">
                        <x-slot name="append">
                            <x-button
                                class="h-full"
                                icon="plus"
                                rounded="rounded-r-md"
                                amber
                                wire:click='addCategory; positionable.close()'
                            />
                        </x-slot>
                    </x-input>
                </x-slot>
            </x-select>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-input id="type" name="type" wire:model="type" label="Type"/>
        </div>
    </div>

    <div class="mt-4">
        <p></p>
    </div>
    <div class="mt-4">
        <p></p>
    </div>
    <div class="mt-4">
        <p></p>
    </div>
    <div class="mt-4">
        <p></p>
    </div>
    <div class="mt-4">
        <p></p>
    </div>
    <div class="mt-4">
        <p></p>
    </div>
</div>
