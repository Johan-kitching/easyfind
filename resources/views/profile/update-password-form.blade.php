<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        @if(Auth::user()->cannot("Admin Users - Edit") || $user->id == Auth::user()->id)
            <div class="col-span-6 sm:col-span-4">
                <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model="state.current_password" autocomplete="current-password" label="{{ __('Current Password') }}"/>
                <x-input-error for="current_password" class="mt-2"/>
            </div>
        @endif
        <div class="col-span-6 sm:col-span-4">
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model="state.password" autocomplete="new-password" label="{{ __('New Password') }}"/>
            <x-input-error for="password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model="state.password_confirmation" autocomplete="new-password" label="{{ __('Confirm Password') }}"/>
            <x-input-error for="password_confirmation" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="updatePassword" type="submit">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
