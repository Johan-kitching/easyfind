@props([
    'gradient' => false
])

@if($gradient)
    <span
        {{ $attributes->merge(['class' => 'block w-full h-px bg-gradient bg-gradient-to-r from-white via-black/10 to-white dark:from-gray-800 dark:via-white/10 dark:to-gray-800']) }}
    ></span>
@else
    <span
        {{ $attributes->merge(['class' => 'text-center text-sm text-gray-500 flex justify-between']) }}
    >
        <span class="w-full h-px z-10 self-center bg-gradient-to-r from-white to-black/10 dark:from-gray-800 dark:to-white/10"></span>
        <span class="px-3 min-w-max z-20">
            {{ $slot ?? trans_choice('custom/member.details', 2) }}
        </span>
        <span class="w-full h-px z-10 self-center bg-gradient-to-r from-black/10 to-white dark:from-white/10 dark:to-gray-800"></span>
    </span>
@endif
