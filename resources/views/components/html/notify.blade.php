@props([
    'for' => '',
])

<span
    x-data="{ open: false }"
    x-init="
        @this.on('notify-saved{{$for}}', () => {
            if (open === false) setTimeout(() => { open = false }, 2500);
            open = true;
        });
    "
    x-show.transition.out.duration.1000="open"
    style="display: none;"
    {{ $attributes->merge(['class' => 'mr-3 mt-2 font-medium text-black dark:text-gray-200']) }}
>
    {{ trans('custom/actions.saved') }}!
</span>
