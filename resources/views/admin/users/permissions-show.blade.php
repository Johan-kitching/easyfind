<!-- Modal -->
<div
    data-te-modal-init
    data-te-backdrop="false"
    class="static left-0 top-0 z-[1055] block h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="exampleModalComponents"
    tabindex="-1"
    aria-labelledby="exampleModalComponentsLabel"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto opacity-100 transition-all duration-300 ease-in-out ">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-slate-800">
            <x-modal-header>Permission: {{$name}}</x-modal-header>
            <div class="relative flex-auto p-4" data-te-modal-body-ref>
                <div class="flex flex-nowrap gap-4">
                    {{--                    Content--}}
                    <div class="my-2 w-full" x-transition>
                        <x-slot name="header">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Permissions') }}
                            </h2>
                        </x-slot>
                        <div class="flex flex-nowrap gap-4">
                            {{--                    Content--}}
                            <div class="my-2 w-full text-center" x-transition>
                                <div class="text-left w-full flex justify-center">
                                    <form id="locationForm" class="w-full max-w-5xl">
                                        @if($new=='true')
                                            <x-input id="name" name="name" wire:model="name" placeholder="Name" required label="Name"/>
                                        @else
                                            <x-input class="readonly:border-none readonly:bg-transparent" color="none" id="name" name="name" wire:model="name" placeholder="Name" required label="Name" readonly/>
                                        @endif
                                        <p class="h-2"></p>
                                            <div
                                                class="w-full text-center items-center rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50 dark:text-white">
                                                Permissions
                                            </div>
                                        <div class="grid grid-cols-3 gap-4 w-full">
                                            @foreach($permissions as $permission)
                                                @php
                                                    $section = explode(' - ', $permission['name']);
                                                @endphp
                                                @if($section[0]!=$prev && $prev != null)
                                        </div>
                                        <div class="py-8">
                                            <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4 w-full">
                                            @endif
                                            @php
                                                $prev = $section[0];
                                            @endphp

                                            <x-toggle label="{{ucfirst(str_replace('_', ' ',$permission['name']))}}" wire:model="currentPermission.{{$permission['id']}}" info></x-toggle>
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <x-button
                        type="button"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-te-modal-dismiss
                        data-te-ripple-init
                        data-te-ripple-color="light"
                        negative
                        wire:click="$dispatch('closeModal')">
                        Close
                    </x-button>
                    <x-button
                        spinner="save"
                        type="button"
                        class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                        data-te-ripple-init
                        data-te-ripple-color="light" wire:click='save'>
                        Save changes
                    </x-button>
                </div>
            </div>
        </div>
    </div>
