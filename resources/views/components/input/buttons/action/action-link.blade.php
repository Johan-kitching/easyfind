@props([
    'href'
])

<a
    href="{{ $href ?? '#' }}"
    {{ $attributes }}
    @click="open = false"
    class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:no-underline dark:text-gray-200 hover:dark:bg-secondary-600"
    role="menuitem"
>
    {{ $slot ?? '' }}
</a>
