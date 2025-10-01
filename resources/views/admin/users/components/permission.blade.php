<x-action-section>
    <x-slot name="title">
        {{ __('User Permission') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Select the group of permission assigned to this user.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('') }}
        </div>
        <x-select id="type" name="type" wire:model.defer="type" placeholder="Please Select"
                  :options="$types" option-value="name"
                  option-label="name" label="Permission"/>
        <p>&nbsp;</p>
    </x-slot>
</x-action-section>
