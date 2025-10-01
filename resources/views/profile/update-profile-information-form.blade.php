<x-form-section submit="updateProfileInformation" x-data="{type: '{{$this->user->type}}'}">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
{{--@dd($this)--}}
        @if(Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" accept="image/png, image/gif, image/jpeg"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            "/>

                <x-label for="photo" value="{{ __('Photo') }}"/>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2"/>
            </div>
        @endif
        <div class="grid grid-cols-2 gap-4 col-span-6 sm:col-span-4">
            <x-radio id="typePersonal" name="type" value="Personal" x-model="type" wire:model="state.type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">{{--{{$this->user->type=='Personal'?'checked':''}}--}}
                <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                    <x-icon name="home" class="w-5 h-5"/>
                    Personal
                </x-slot>
            </x-radio>
            <x-radio id="typeCompany" name="type" value="Company" x-model="type" wire:model="state.type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">
                <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                    <x-icon name="building-office" class="w-5 h-5"/>
                    Company
                </x-slot>
            </x-radio>
        </div>
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4" id="Personal" x-show="type == 'Personal'" x-transition.opacity>
            <div class="mt-4">
                <x-input id="memberName" class="block mt-1 w-full" type="text" name="memberName" wire:model="state.memberName" label="{{ __('Full Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input id="number" class="block mt-1 w-full" type="text" name="number" wire:model="state.number" label="{{ __('Primary Contact Number') }}"/>
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4" id="Company" x-show="type == 'Company'" x-transition.opacity>
            <div class="mt-4">
                <x-input id="companyName" class="block mt-1 w-full" type="text" name="companyName" wire:model="state.companyName" :value="old('companyName')" label="{{ __('Company Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input id="companyContact" class="block mt-1 w-full" type="text" name="companyContact" wire:model="state.companyContact" :value="old('companyContact')" label="{{ __('Contact Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input id="companyNumber" class="block mt-1 w-full" type="text" name="companyNumber" wire:model="state.companyNumber" :value="old('companyNumber')" label="{{ __('Primary Contact Number') }}"/>
            </div>
            <div class="mt-4">
                <x-input id="website" class="block mt-1 w-full" prefix="https://www." type="text" name="website" wire:model="state.website" :value="old('website')" autocomplete="website" label="{{ __('Website') }}"/>
            </div>

        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-input id="address" class="block mt-1 w-full" type="address" name="address"  wire:model="state.address" required autocomplete="address" label="{{ __('Physical Address') }}"/>
        </div>
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" label="{{ __('Email') }}"/>

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 dark:text-white">
                    {{ __('Your email address is unverified.') }}

                    <button type="button"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
        <script>
            function handleClick(e) {
                // console.log(e);
                const Personal = document.getElementById('Personal').getElementsByTagName("input");
                const Company = document.getElementById('Company').getElementsByTagName("input");
                if (e == 'Personal') {

                    for (const child of Personal) {
                        child.required = true;
                    }

                    for (const child of Company) {
                        child.required = false;
                    }
                } else {

                    for (const child of Company) {
                        child.required = true;
                    }

                    for (const child of Personal) {
                        child.required = false;
                    }
                }
            }
        </script>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo" type="submit">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
