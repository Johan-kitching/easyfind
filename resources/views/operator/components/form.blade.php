<div class="text-left w-full justify-center grid grid-cols-1">
    <div class="mt-4"> {{$name}}
        <x-input icon="user" id="name" class="block mt-1 w-full" type="text" name="name" wire:model.blur="name" label="{{ __('Full Name') }}"/>
    </div>
    <div class="mt-4">
        <x-input icon="device-phone-mobile" id="number" class="block mt-1 w-full" type="text" name="number" wire:model.blur="number" label="{{ __('Primary Contact Number') }}"/>
    </div>
    <div class="mt-4 w-full">
        <x-input icon="envelope" id="email" type="email" class="mt-1 block w-full" wire:model.blur="email" required autocomplete="username" label="{{ __('Email') }}"/>
    </div>
    <div class="mt-4">
        <x-input icon="lock-closed" id="password" class="block mt-1 w-full" type="password" name="password" wire:model="password" required autocomplete="new-password" label="{{ __('Password') }}"/>
    </div>

    <div class="mt-4">
        <x-input icon="lock-closed" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" wire:model="password_confirmation" required autocomplete="new-password"
                 label="{{ __('Confirm Password') }}"/>
    </div>
    <div class="mt-4 w-full">
        <x-select icon="truck" id="equipment" name="equipment" wire:model.live="equipment" :options="$equipments" option-value="id" option-label="variant" label="Machinery" multiselect/>
    </div>
    <div class="mt-4 w-full">
        <x-select icon="truck" id="transporter" name="transporter" wire:model.live="transporter" :options="$transporters" option-value="id" option-label="variant" label="Transporter" multiselect/>
    </div>
</div>
