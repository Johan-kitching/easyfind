@props([
    'type' => 'button',
    'action' => 'Edit',
    'allow' => true,
    'full' => true,
])

<div>
    <span
        x-data="{ open: false }"
        @keydown.escape.stop="open = false"
        @keydown.window.escape="open = false"
        @click.away="open = false"
        class="relative inline-flex rounded-md text-gray-700"
    >
        @if($allow)
            @if($type == 'button')
                <x-button-me
                    label="{{ $action ?? '' }}"
                    {{ $attributes->merge(['class' => ($full) ? 'relative inline-flex items-center px-4 py-1 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400 w-full' : 'relative inline-flex items-center px-4 py-1 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400']) }}/>

            @else
                <a {{ $attributes->merge(['class' => ($full) ? 'relative inline-flex items-center px-4 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400 w-full hover:dark:bg-secondary-600' : 'relative inline-flex items-center px-4 py-1 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400 hover:dark:bg-secondary-600']) }}>
                    {{ $action }}
                </a>
            @endif
        @else
            <span
                class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400">
                Actions
            </span>
        @endif
        @if($slot->isNotEmpty())
            <span class="-ml-px relative block" :key="reminder:edit:drop.{{ time() }}">
                <button @click="open = !open" type="button"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400 hover:dark:bg-secondary-600"
                        id="option-menu-button" aria-expanded="true" aria-haspopup="true">
                  <span class="sr-only">Options</span>
                  <x-icon name="chevron-down" class="h-5 w-5"/>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="origin-top-right absolute z-10 right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 border border-gray-200 divide-y divide-gray-200 focus:outline-none dark:bg-secondary-800 dark:divide-gray-600 dark:border-gray-600 w-fit min-w-[106px] top-[30px]"
                    role="menu"
                    aria-orientation="vertical"
                    @keydown.tab="open = false"
                    @keydown.enter.prevent="open = false"
                    @keyup.space.prevent="open = false"
                    style="display: none;"
                >
                  <div class="py-1 divide-y divide-gray-100 text-left dark:divide-gray-600" role="none">
                      {{ $slot ?? '' }}
                  </div>
                </div>
            </span>
        @endif
    </span>

</div>
