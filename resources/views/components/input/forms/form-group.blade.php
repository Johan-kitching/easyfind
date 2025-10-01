@props([
    'col' => 2
])

<div
    {{ $attributes->merge(['class' => 'col-span-4 sm:col-span-1 lg:col-span-' . $col]) }}
>
    {{ $slot }}
</div>
