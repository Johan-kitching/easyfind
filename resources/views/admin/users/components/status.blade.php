<x-action-section>
    <x-slot name="title">
        {{ __('User Status') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Select the user status.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('') }}
        </div>
{{--        @dd($this->user)--}}
        <x-select id="status" name="status" wire:model.defer="status" placeholder="Please Select" label="Status">
            <x-select.option value='active'>Active</x-select.option>
            <x-select.option value='inactive'>Inactive</x-select.option>
        </x-select>
    </x-slot>
</x-action-section>
