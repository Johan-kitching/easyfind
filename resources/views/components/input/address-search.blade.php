<div class="input-group">
    <div id="mapField">
    @script
    <script type="module">
        window.initMap = async function () {
            console.log('Loaded');
            // Request needed libraries.
            //@ts-ignore
            await google.maps.importLibrary("places");

            // Create the input HTML element, and append it.
            // const input = document.createElement("input");
            // input.id = "autocomplete";
            // document.getElementById('mapField').appendChild(input);
            const input = document.getElementById('autocomplete');

            // Initialize the Autocomplete object.
            //@ts-ignore
            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: {country: "za"}, // Restrict to South Africa
            });

            // Inject HTML UI.
            const selectedPlaceTitle = document.createElement("p");
            selectedPlaceTitle.textContent = "";
            document.body.appendChild(selectedPlaceTitle);

            const selectedPlaceInfo = document.createElement("pre");
            selectedPlaceInfo.textContent = "";
            document.body.appendChild(selectedPlaceInfo);

            // Add the place_changed listener, and display the results.
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                @this.
                set('address', place.address);
                console.log(place);
                selectedPlaceTitle.textContent = "Selected Place:";
                selectedPlaceInfo.textContent = JSON.stringify(
                    place,
                    /* replacer */ null,
                    /* space */ 2,
                );
            });
        }

        initMap();
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("libraries", [...r] + "");
                for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " could not load."));
                a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                m.head.append(a)
            }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })
        ({key: "{{ env('GOOGLE_MAPS_API_KEY') }}", v: "beta"});</script>
    @endscript

        <x-input icon="map-pin" id="autocomplete" class="block mt-1 w-full" type="text" name="address-add" autocomplete="street-address" label="{{ __('Physical Address') }}"/>
    </div>
</div>
