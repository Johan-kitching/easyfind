<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
{{--            <x-authentication-card-logo/>--}}
        </x-slot>

        <x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}" x-data="{type: 'Company'}">
            @csrf
            <x-label>Account Type<br>&nbsp;</x-label>
            <div class="grid grid-cols-2 gap-4">
                <x-radio id="typePersonal" name="type" value="Personal" x-model="type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">
                    <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                        <x-icon name="home" class="w-5 h-5"/>
                        User
                    </x-slot>
                </x-radio>
                <x-radio id="typeCompany" name="type" value="Company" x-model="type" @click.debounce.500ms="handleClick(type)" class="!cursor-pointer dark:bg-gray-800 dark:text-white">
                    <x-slot name="label" class="inline-flex justify-center w-full gap-4 cursor-pointer">
                        <x-icon name="building-office" class="w-5 h-5"/>
                        Service Provider
                    </x-slot>
                </x-radio>
            </div>

            {{-- Personal Info --}}
            <div id="Personal" x-show="type == 'Personal'" x-transition.opacity>
                <div class="mt-4">
                    <x-input icon="user" id="memberName" class="block mt-1 w-full" type="text" name="memberName" :value="old('memberName')" label="{{ __('Full Name') }}"/>
                </div>
                <div class="mt-4">
                    <x-input icon="device-phone-mobile" id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')" label="{{ __('Primary Contact Number') }}"/>
                </div>
            </div>

            {{-- Company Info --}}
            <div id="Company" x-show="type == 'Company'" style="display: none;" x-transition.opacity>
                <div class="mt-4">
                    <x-input icon="building-office" id="companyName" class="block mt-1 w-full" type="text" name="companyName" :value="old('companyName')" label="{{ __('Company Name') }}"/>
                </div>
                <div class="mt-4">
                    <x-input icon="user" id="companyContact" class="block mt-1 w-full" type="text" name="companyContact" :value="old('companyContact')" label="{{ __('Contact Name') }}"/>
                </div>
                <div class="mt-4">
                    <x-input icon="device-phone-mobile" id="companyNumber" class="block mt-1 w-full" type="text" name="companyNumber" :value="old('companyNumber')" label="{{ __('Primary Contact Number') }}"/>
                </div>
                <div class="mt-4">
                    <x-input id="website" class="block mt-1 w-full" prefix="https://www." type="text" name="website" :value="old('website')" autocomplete="website" label="{{ __('Website') }}"/>
                </div>
            </div>
            {{-- End --}}

            <div class="mt-4">
                <x-input icon="map-pin" id="address" class="block mt-1 w-full map-input" name="address" :value="old('address')" required autocomplete="address" label="{{ __('Company Physical Address') }}"/>
                <x-input class="hidden" icon="map" readonly name="address_latitude" id="address_latitude" required label="{{ __('Latitude') }}"/>
                <x-input class="hidden" icon="map" readonly name="address_longitude" id="address_longitude" required label="{{ __('Longitude') }}"/>
                <x-input class="hidden" icon="globe-europe-africa" readonly name="city" id="city" required label="{{ __('City') }}"/>
            </div>
            <div id="demo"></div>
            <div class="mt-4">
                <x-input icon="envelope" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" label="{{ __('Email') }}"/>
            </div>

            <div class="mt-4">
                <x-input icon="lock-closed" id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required autocomplete="new-password" label="{{ __('Password') }}"/>
            </div>

            <div class="mt-4">
                <x-input icon="lock-closed" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')" required autocomplete="new-password"
                         label="{{ __('Confirm Password') }}"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required class="!cursor-pointer bg-slate-300 dark:bg-gray-800"/>

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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button type="submit" class="ms-4">
                    {{ __('Register') }}
                </x-button>
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
{{--            @section('scripts')--}}
{{--                @parent--}}
{{--                <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&loading=async" defer></script>--}}
                <script>
                    console.log('loaded');
                    function getReverseGeocodingData(lat, lng) {
                        var latlng = new google.maps.LatLng(lat, lng);
                        // This is making the Geocode request
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({'latLng': latlng}, function (results, status) {
                            if (status !== google.maps.GeocoderStatus.OK) {
                                alert(status);
                            }
                            // This is checking to see if the Geoeode Status is OK before proceeding
                            if (status == google.maps.GeocoderStatus.OK) {
                                var address;
                                var city;
                                // console.log(results);
                                results.forEach(function (result){
                                    // console.log(result.types[0],result.address_components[0].long_name)
                                    if(result.types[0]=='route') {
                                        // console.log(result.formatted_address);
                                        address = result.formatted_address;
                                    }
                                    if(result.types[0]=='locality') {
                                        // console.log(result.address_components[0].long_name);
                                        city = result.address_components[0].long_name;
                                    }
                                });
                                // var address = (results[1].formatted_address);
                                document.getElementById('address').value = address;
                                document.getElementById('city').value = city;
                                document.getElementById("address_latitude").value = lat;
                                document.getElementById("address_longitude").value = lng;
                            }
                        });
                    }

                    const x = document.getElementById("demo");

                    function getLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showPosition);
                        } else {
                            x.innerHTML = "Geolocation is not supported by this browser.";
                        }
                    }

                    function showPosition(position) {
                        getReverseGeocodingData(position.coords.latitude, position.coords.longitude)
                    }
                    function initAutocomplete() {
                        setTimeout(function () {
                            document.getElementById("address").value = null;
                            getLocation();
                        }, 1000);
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
                                    // console.log(val);
                                }
                            }
                            document.getElementById("address_latitude").value = lat;
                            document.getElementById("address_longitude").value = lng;
                        });
                    }

                    window.addEventListener('load', initAutocomplete);
                </script>
{{--            @stop--}}
        </form>
    </x-authentication-card>
</x-app-layout>
