<div class="flex flex-wrap p-5 gap-4 justify-center">
    @foreach($this->transporters as $transporter)
        <x-card title="{{$transporter->id}} - {{$transporter->type->name}}" rounded="3xl" shadow="2xl" class="hover:shadow-none">
            <div>
                {{--                <x-avatar xl rounded="rounded-[1.25rem]" :src="$machinery->photos?->first()?->fullPath" size="w-64 h-64"/>--}}
                @if($transporter->photos?->first()?->fullPath)

                    <img class="object-cover w-64 h-64" alt="Machinery Image" src="{{$transporter->photos?->first()?->fullPath}}">
                @else
                    <div class="w-64 h-64 text-center content-center"> No Image Found</div>
                @endif
                <div class="text-xs justify-center grid">{{Str::of($transporter->address)->words(5, ' ...')}}</div>
            </div>
            <x-slot name="footer" class="flex items-start justify-center gap-1">
                <x-button xs icon="map-pin" label="Update Location" emerald x-on:click="checkTransporterLocationSettings('{{$transporter->id}}')"/>
                <x-button xs icon="clock" label="Availability" secondary onclick="Livewire.dispatch('openModal', {component: 'Transporter.availability', arguments: {{ json_encode([$transporter->id]) }} })"/>
            </x-slot>
        </x-card>
    @endforeach
    @script
    <script language="JavaScript">
        let vid = 1;
        window.checkTransporterLocationSettings = function (id) {

            vid = id;
            if (navigator.geolocation) {
                console.log(id);
                navigator.geolocation.getCurrentPosition(showPosition, openModule);
            } else {
                console.log("Geolocation is not supported by this browser.");
                openModule();
            }
        }

        function openModule() {
            // console.log("failed" + vid);
            Livewire.dispatch('openModal', {component: 'Transporter.UpdateTransporterLocationModal', arguments: {transporter:parseInt(vid)}});
        }

        function showPosition(position) {
            console.log(position);
            getReverseGeocodingData(position.coords.latitude, position.coords.longitude)
        }

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
                    results.forEach(function (result) {
                        // console.log(result.types[0],result.address_components[0].long_name)
                        // console.log(result.types[0]);
                        if (result.types[0] == 'route') {
                            console.log(result.formatted_address);
                            address = result.formatted_address;
                        }
                        if (result.types[0] == 'locality') {
                            // console.log(result.address_components[0].long_name);
                            city = result.address_components[0].long_name;
                        }
                    });
                    // $wire.dispatch('confirmUpdateTransporter',{id: vid, address: address, city: city, lat: lat, long: lng});
                    // Livewire.dispatch('confirmUpdateTransporter', {id: vid, address: address, city: city, lat: lat, long: lng});
                    // Livewire.dispatch('openModal',{component:'confirmUpdateTransporter', arguments: {id: vid, address: address, city: city, lat: lat, long: lng}});
                    Livewire.dispatch('openModal', {component: 'Transporter.UpdateTransporterLocationModal', arguments: {transporter:parseInt(vid), address: address, city: city, address_latitude: lat, address_longitude: lng}});
                    console.log({id: vid, address: address, city: city, lat: lat, long: lng});
                }
            });
        }
    </script>
    @endscript
</div>
