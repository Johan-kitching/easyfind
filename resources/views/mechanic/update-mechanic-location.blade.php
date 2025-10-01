<div class="flex flex-wrap p-5 gap-4 justify-center">
    @foreach($this->mechanics as $mechanic)
        <x-card title="{{$mechanic->name}} - {{$mechanic->type->name}}" rounded="3xl" shadow="2xl" class="hover:shadow-none">
            <div style="height: 256px; width: 256px;">
                Description:
                {!! $mechanic->description !!}
            </div>
            <x-slot name="footer" class="flex items-start justify-center gap-1">
                <x-button xs icon="map-pin" label="Update Location" emerald x-on:click="checkMechanicLocationSettings('{{$mechanic->id}}')"/>
                <x-button xs icon="clock" label="Availability" secondary onclick="Livewire.dispatch('openModal', {component: 'Mechanic.availability', arguments: {{ json_encode([$mechanic->id]) }} })"/>
            </x-slot>
        </x-card>
    @endforeach
    @script
    <script language="JavaScript">
        let vid = 1;
        window.checkMechanicLocationSettings = function (id) {

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
            Livewire.dispatch('openModal', {component: 'Mechanic.UpdateMechanicLocationModal', arguments: {mechanic:parseInt(vid)}});
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
                    // $wire.dispatch('confirmUpdateMechanic',{id: vid, address: address, city: city, lat: lat, long: lng});
                    // Livewire.dispatch('confirmUpdateMechanic', {id: vid, address: address, city: city, lat: lat, long: lng});
                    // Livewire.dispatch('openModal',{component:'confirmUpdateMechanic', arguments: {id: vid, address: address, city: city, lat: lat, long: lng}});
                    Livewire.dispatch('openModal', {component: 'Mechanic.UpdateMechanicLocationModal', arguments: {mechanic:parseInt(vid), address: address, city: city, address_latitude: lat, address_longitude: lng}});
                    console.log({id: vid, address: address, city: city, lat: lat, long: lng});
                }
            });
        }
    </script>
    @endscript
</div>
