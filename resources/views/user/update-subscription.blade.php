<div
    data-te-modal-init
    data-te-backdrop="false"
    class="static left-0 top-0 z-[1055] block h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="newMachinery"
    tabindex="-1"
    aria-labelledby="newMachinery"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto opacity-100 transition-all duration-300 ease-in-out ">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-slate-800">
            <x-modal-header>Update My Package</x-modal-header>
            <div class="relative flex-auto p-4" data-te-modal-body-ref x-data="{ submitButtonDisabled: 0}">
                <div class="flex flex-nowrap gap-4">
                    {{--                    Content--}}
                    <div class="my-2 w-full" x-transition>
                        <div class="flex place-content-center">
                            <div class="ml-4 w-fit">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $package->name }}</h2>
                                <p class="text-gray-600 dark:text-gray-400">{{ $package->assets }}x Assets</p>
                                <p class="text-gray-800 dark:text-gray-200 font-bold text-xl w-full text-right">R{{ $package->price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
{{--                    <x-button--}}
{{--                        type="button"--}}
{{--                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"--}}
{{--                        data-te-modal-dismiss--}}
{{--                        data-te-ripple-init--}}
{{--                        data-te-ripple-color="light"--}}
{{--                        negative--}}
{{--                        wire:click="$dispatch('closeModal')">--}}
{{--                        Close--}}
{{--                    </x-button>--}}
                    @if(Auth::user()->pf_token)
                        @if($package->id!=Auth::user()->package_id && Auth::user()->pf_token)
                            <x-button label="Change" wire:click="confirmUpgrade()"/>
                        @else
                            @if(Auth::user()->pf_status=='Paused')
                                <x-button label="Resume" wire:click="confirmResume()"/>
                            @else
                                <x-button label="Pause" wire:click="confirmPause()"/>
                            @endif
                            <x-button label="Cancel" negative wire:click="confirmCancel()"/>
                        @endif
                    @else
                        {!! $button !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
