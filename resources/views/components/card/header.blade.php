<x-slot name="header">
    <div
        {{ $attributes->merge(['class' => 'flex rounded-tl-lg rounded-tr-lg px-2 pt-5 pb-2 md:px-4']) }}
    >
        <div class="flex-1">
            <h2 {{ $attributes->merge(['class' => 'text-xl leading-6 font-medium text-gray-900 dark:text-gray-200']) }}">
                <div class="flex">
                    @if($icon ?? '')
                        <div class="mr-2">
                            <x-icon name='{{ $icon }}' class='h-5 w-5 text-gray-600 dark:text-gray-400'/>
                        </div>
                    @endif
                    <div>
                        {!! $subject ?? '' !!}
                    </div>
                </div>
            </h2>
            <p class="mt-1 mb-2 text-sm text-gray-400 dark:text-gray-400">{{ $description ?? '' }}</p>
        </div>
        <div class="flex">
            <div>
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
    @if($devider ?? '')
        <x-html.devider :gradient="true" class="mb-2"/>
    @endif
</x-slot>
