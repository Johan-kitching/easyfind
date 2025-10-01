<div
    data-te-modal-init
    data-te-backdrop="false"
    class="static left-0 top-0 z-[1055] block h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="editMachinery"
    tabindex="-1"
    aria-labelledby="View Machinery"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto opacity-100 transition-all duration-300 ease-in-out ">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-slate-800">
            <x-modal-header>{{$mechanic->type->name}} - {{$mechanic->name}}</x-modal-header>
            <div class="relative flex-auto p-4" data-te-modal-body-ref x-data="{ submitButtonDisabled: 0}">
                <div class="flex flex-nowrap gap-4">
                    {{--                    Content--}}
{{--                    <div class="my-2 w-fit text-center" x-transition>--}}
{{--                        <div class="w-fit">--}}
{{--                            <div x-data="{mainUrl:'{{$mechanic->photos->first()->fullPath}}'}">--}}
{{--                                <div class="shrink-0 inline-flex items-center justify-center overflow-hidden border-secondary-200 dark:border-secondary-500 bg-secondary-300 dark:bg-secondary-600 border w-80 h-80 rounded-[1.25rem]"--}}
{{--                                     id="MainImage" xl="xl">--}}
{{--                                    <img class="w-full h-full object-cover" alt="Machinery Image" x-bind:src="mainUrl">--}}
{{--                                </div>--}}
{{--                                <div id="SmallImage" class="flex justify-end">--}}
{{--                                    @foreach($mechanic->photos as $photo)--}}
{{--                                        <x-avatar xl rounded="rounded-[0.25rem]" :src="$photo->fullPath" size="w-10 h-10" class="mx-0.5 hover:drop-shadow-md cursor-pointer hover:border hover:border-white hover:dark:border-black"--}}
{{--                                                  @click="mainUrl='{{$photo->fullPath}}'"/>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="text-left dark:text-gray-200 text-gray-800">
                        @if($mechanic->user->companyName)
                            <div><span class="dark:text-gray-500 text-gray-400">Company:</span> <br>{{$mechanic->user->companyName}}</div>
                        @endif
                        <div><span class="dark:text-gray-500 text-gray-400">Contact Name:</span> <br>{{$mechanic->user->companyContact ?? $mechanic->user->memberName}}</div>
                        <div><span class="dark:text-gray-500 text-gray-400">Contact Number:</span> <br>{{$mechanic->user->companyNumber ?? $mechanic->user->number}}</div>
                        @if($mechanic->user->website)
                            <div><span class="dark:text-gray-500 text-gray-400">Website:</span> <br>{{$mechanic->user->website}}</div>
                        @endif
                        @if($mechanic->user->address)
                            <div><span class="dark:text-gray-500 text-gray-400">Address:</span> <br>{{$mechanic->user->address}}</div>
                        @endif
                        @if($mechanic->address)
                            <div><span class="dark:text-gray-500 text-gray-400">Current Address:</span> <br>{{$mechanic->user->address}}</div>
                        @endif
                        @if($mechanic->description)
                            <div><span class="dark:text-gray-500 text-gray-400">Description:</span> <br>{!! $mechanic->description !!}</div>
                        @endif
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
                </div>
            </div>
        </div>
    </div>
</div>
