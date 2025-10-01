<x-card
    {{ $attributes->merge([
        'cardClasses' => 'border border-gray-200 dark:border-none',
        'headerClasses' => 'dark:border-secondary-600'
    ]) }}
    padding="p-0"
>
    @if(isset($header))
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endif

    <div class="px-2 pb-4 md:px-4">
        {{ $slot ?? '' }}
    </div>

    @if(isset($footer))
        <x-slot name="footer">
            {{ $footer }}
        </x-slot>
    @endif
</x-card>
