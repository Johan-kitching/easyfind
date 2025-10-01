<form
    method="{{ $post ?? 'POST' }}"
    wire:submit="{{ $action ?? 'submit' }}"
    {{ $attributes }}
>
    @csrf

    {{ $slot ?? '' }}
</form>
