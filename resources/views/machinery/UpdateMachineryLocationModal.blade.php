<div
    data-te-modal-init
    data-te-backdrop="false"
    class="static left-0 top-0 z-[1055] block h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="newMachinery"
    tabindex="-1"
    aria-labelledby="newMachinery">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto opacity-100 transition-all duration-300 ease-in-out ">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-slate-800">
            <x-modal-header>Updating: {{$machinery->type->category}} - {{$machinery->type->type}}</x-modal-header>
            <div class="relative flex-auto p-4" data-te-modal-body-ref x-data="{ submitButtonDisabled: 0}">
                <div class="">
                    {{--                    Content--}}
                    <div class="my-2 w-full text-center" x-transition>
                        <div class="text-left w-full justify-center grid grid-cols-1">
                            <div class="w-full">
                                <div class="mt-4 w-full">
                                    <div>
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
                                                    // const selectedPlaceTitle = document.createElement("p");
                                                    // selectedPlaceTitle.textContent = "";
                                                    // document.body.appendChild(selectedPlaceTitle);
                                                    //
                                                    // const selectedPlaceInfo = document.createElement("pre");
                                                    // selectedPlaceInfo.textContent = "";
                                                    // document.body.appendChild(selectedPlaceInfo);

                                                    // Add the place_changed listener, and display the results.
                                                    autocomplete.addListener("place_changed", () => {
                                                        const place = autocomplete.getPlace();
                                                        if (place.address_components && Array.isArray(place.address_components)) {
                                                            place.address_components.forEach(function (component) {
                                                                if (Array.isArray(component.types) && component.types[0] === 'locality') {
                                                                    const cityValue = component.long_name;
                                                                    console.log(cityValue);
                                                                    @this.set('city', cityValue);
                                                                }
                                                            });
                                                        }
                                                        const latitude = place.geometry.location?.lat();
                                                        const longitude = place.geometry.location?.lng();
                                                        @this.set('address', place.formatted_address);
                                                        @this.set('address_latitude', latitude);
                                                        @this.set('address_longitude', longitude);
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
                                                ({key: "{{ config('services.google_maps.key') }}", v: "beta"});</script>
                                            @endscript

                                            <x-input icon="map-pin" id="autocomplete" class="block mt-1 w-full" type="text" name="address-add" autocomplete="street-address" label="{{ __('Physical Address') }}" wire:model="address" />
                                        </div>
                                        <x-input icon="map" readonly name="address_latitude" id="address_latitude" wire:model="address_latitude" required label="{{ __('Latitude') }}"/>
                                        <x-input icon="map" readonly name="address_longitude" id="address_longitude" wire:model="address_longitude" required label="{{ __('Longitude') }}"/>
                                        <x-input icon="globe-europe-africa" readonly name="city" id="city" required wire:model="city" label="{{ __('City') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <button
                            type="button"
                            class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                            data-te-modal-dismiss
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            @click="$dispatch('closeModal')">
                            Close
                        </button>
                        <button
                            x-bind:disabled="submitButtonDisabled!=0"
                            type="button"
                            class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                            data-te-ripple-init
                            data-te-ripple-color="light" @click="$wire.save()">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
