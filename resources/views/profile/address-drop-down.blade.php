<div>
    <div x-data="{ title: 'Sure Delete?' }">
        <x-button warning label="Delete" wire:click="confirmRemove('{{$id}}')" />
    </div>
</div>
