<div
    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50 bg-[#093c78] h-[100px] align-middle">
    <span
        class="text-xl font-medium leading-normal text-white"
        id="exampleModalComponentsLabel">
        {{$slot}}
    </span>
    <div class="bg-[#038fb8] w-[200px] h-[200px] absolute right-[-100px] z-0 rotate-45 top-[-100px]"></div>
    <div class="bg-[#22bcea] w-[200px] h-[200px] absolute right-[-120px] z-1 rotate-45 top-[-2px]"></div>
    @if(!isset($noClose))
    <button
        type="button"
        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none absolute right-10 z-10"
        data-te-modal-dismiss
        aria-label="Close"
        wire:click="$dispatch('closeModal')">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6 shadow-black shadow-md rounded-full text-[#ad9c9c] bg-[#093c78]">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    @endif
</div>
