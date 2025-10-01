<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-input id="name" name="name" wire:model.live="name" :options="$name" label="Name"/>
        </div>
        <div class="mt-4 w-full">
            <x-select id="type" name="type" wire:model.live="type" :options="$types" option-value="id" option-label="name" label="Type"/>
        </div>
    </div>
    <div class="w-full">
        <div class="mt-4 w-full">
            <x-trix id="description" name="description" wire:model.live="description" label="Description" placeholder="Please provide a complete and full description of you mechanic, including his experience and qualifications."/>
        </div>
    </div>
</div>
