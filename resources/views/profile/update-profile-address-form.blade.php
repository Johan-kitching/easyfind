<x-form-section>
    <x-slot name="title">
        {{ __('Address Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your address.') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-input icon="map-pin" id="address-add" class="block mt-1 w-full" type="text" name="address-add" autocomplete="street-address" label="{{ __('Physical Address') }}">
                <x-slot name="append">
                    <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                        <x-button
                            class="h-full rounded-r-md dark:bg-slate-700 dark:hover:bg-slate-900 dark:text-gray-400 dark:hover:text-white" alt="Add"
                            icon="plus"
                            primary
                            flat
                            squared
                            wire:click="update"
                        />
                    </div>
                </x-slot>
            </x-input>

            <x-input type="text"  icon="map" readonly name="address_latitude" id="address_latitude" required label="{{ __('Latitude') }}" wire:model.change="address_latitude"/>
            <x-input type="text"  icon="map" readonly name="address_longitude" id="address_longitude" required label="{{ __('Longitude') }}" wire:model.change="address_longitude"/>
            <x-input type="text"  icon="globe-europe-africa" readonly name="city" id="city" required label="{{ __('City') }}" wire:model.change="city"/>
            @if ($errors->any())
                <div class="text-sm text-red-600 dark:text-red-400 error-message">Please make sure to select your address from the list.</div>
            @endif
            <div id="demo"></div>
            {{--                <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&loading=async" defer></script>--}}
            <script>
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
                            document.getElementById('address-add').value = address;
                            @this.set('address', address);
                            document.getElementById('city').value = city;
                            @this.set('city', city);
                            document.getElementById("address_latitude").value = lat;
                            @this.set('address_latitude', lat);
                            document.getElementById("address_longitude").value = lng;
                            @this.set('address_longitude', lng);
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
                        document.getElementById("address-add").value = null;
                        getLocation();
                    }, 1000);
                    var input = document.getElementById('address-add')
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
                                @this.
                                set('city', val);
                                // console.log(place);
                            }
                        }
                        document.getElementById("address_latitude").value = lat;
                        @this.
                        set('address_latitude', lat);
                        document.getElementById("address_longitude").value = lng;
                        @this.
                        set('address_longitude', lng);
                        @this.
                        set('address', place.formatted_address);
                    });
                }

                function clearForm() {
                    document.getElementById("address_latitude").value = null;
                    document.getElementById("address_longitude").value = null;
                    document.getElementById("city").value = null;
                    document.getElementById("address-add").value = null;
                }

                window.addEventListener('load', initAutocomplete);
                window.addEventListener('reset', clearForm);
            </script>
        </div>

        <div class="col-span-8 sm:col-span-6">
            <livewire:profile.address-list :user="$user"/>
        </div>

    </x-slot>

    {{--    <x-slot name="actions">--}}
    {{--        <x-action-message class="me-3" on="saved">--}}
    {{--            {{ __('Saved.') }}--}}
    {{--        </x-action-message>--}}

    {{--        <x-button wire:loading.attr="disabled" wire:target="photo" type="submit">--}}
    {{--            {{ __('Save') }}--}}
    {{--        </x-button>--}}
    {{--    </x-slot>--}}
</x-form-section>
