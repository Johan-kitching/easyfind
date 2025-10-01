<div class="text-left w-full flex justify-center">
    <form method="POST" action="{{ route('register') }}" x-data="{ type: 'Personal' }">
        @csrf
        <x-label>Account Type<br>&nbsp;</x-label>
        <div class="grid grid-cols-2 gap-4">
            <x-radio id="typePersonal" name="type" value="Personal" x-model="type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">
                <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                    <x-icon name="home" class="w-5 h-5"/>
                    Personal
                </x-slot>
            </x-radio>
            <x-radio id="typeCompany" name="type" value="Company" x-model="type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">
                <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                    <x-icon name="building-office" class="w-5 h-5"/>
                    Company
                </x-slot>
            </x-radio>
        </div>

        {{-- Personal Info --}}
        <div id="Personal" x-show="type == 'Personal'" x-transition.opacity>
            <div class="mt-4">
                <x-input icon="user" id="memberName" class="block mt-1 w-full" type="text" name="memberName" wire:model.blur="memberName" label="{{ __('Full Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input icon="device-phone-mobile" id="number" class="block mt-1 w-full" type="text" name="number" wire:model.blur='number' label="{{ __('Primary Contact Number') }}"/>
            </div>
        </div>

        {{-- Company Info --}}
        <div id="Company" x-show="type == 'Company'" style="display: none;" x-transition.opacity>
            <div class="mt-4">
                <x-input icon="building-office" id="companyName" class="block mt-1 w-full" type="text" name="companyName" wire:model.blur='companyName' label="{{ __('Company Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input icon="user" id="companyContact" class="block mt-1 w-full" type="text" name="companyContact" wire:model.blur='companyContact' label="{{ __('Contact Name') }}"/>
            </div>
            <div class="mt-4">
                <x-input icon="device-phone-mobile" id="companyNumber" class="block mt-1 w-full" type="text" name="companyNumber" wire:model.blur='companyNumber' label="{{ __('Primary Contact Number') }}"/>
            </div>
            <div class="mt-4">
                <x-input id="website" class="block mt-1 w-full" prefix="https://www." type="text" name="website" wire:model.blur='website' autocomplete="website" label="{{ __('Website') }}"/>
            </div>
        </div>
        {{-- End --}}

        <div class="mt-4">
            {{$address}}
            <x-input icon="map-pin" id="address" class="block mt-1 w-full map-input" name="address" wire:model.blur='address' required autocomplete="address" label="{{ __('Physical Address') }}"/>
            <x-input icon="map" readonly name="address_latitude" id="address_latitude" required label="{{ __('Latitude') }}"/>
            <x-input icon="map" readonly name="address_longitude" id="address_longitude" required label="{{ __('Longitude') }}"/>
            <x-input icon="globe-europe-africa" readonly name="city" id="city" required label="{{ __('City') }}"/>
        </div>
        <div class="mt-4">
            <x-input icon="envelope" id="email" class="block mt-1 w-full" type="email" name="email" wire:model.blur='email' required autocomplete="username" label="{{ __('Email') }}"/>
        </div>

        <div class="mt-4">
            <x-input icon="lock-closed" id="password" class="block mt-1 w-full" type="password" name="password" wire:model.blur='password' required autocomplete="new-password" label="{{ __('Password') }}"/>
        </div>

        <div class="mt-4">
            <x-input icon="lock-closed" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" wire:model.blur='password_confirmation' required autocomplete="new-password"
                     label="{{ __('Confirm Password') }}"/>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" value="accepted" wire:model.live="terms" id="terms" required class="!cursor-pointer !bg-slate-300"/>

                        <div class="ms-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
        @endif
        @script
        <script>
            function none(){}

            function initAutocomplete() {
                var input = document.getElementById('address')
                var options = {country: ["za"]}
                var autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.setComponentRestrictions(options);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    var lat = place.geometry.location.lat();
                    var lng = place.geometry.location.lng();
                    var placeId = place.place_id;
                    // to set city name, using the locality param
                    var componentForm = {
                        locality: 'short_name',
                    };
                    for (var i = 0; i < place.address_components.length; i++) {
                        var addressType = place.address_components[i].types[0];
                        if (componentForm[addressType]) {
                            var val = place.address_components[i][componentForm[addressType]];
                            document.getElementById("city").value = val;
                            $wire.$set('city', val);

                        }
                    }
                    document.getElementById("address_latitude").value = lat;
                    document.getElementById("address_longitude").value = lng;
                    $wire.$set('address_latitude', lat);
                    $wire.$set('address_longitude', lng);
                    $wire.$set('address', place.formatted_address);
                    // console.log(place.formatted_address);
                });
            }
            initAutocomplete();
        </script>
        @endscript
    </form>
</div>
