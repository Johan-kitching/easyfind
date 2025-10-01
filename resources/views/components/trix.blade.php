@props([
    'name',
    'label',
    'placeholder',
    'id' => rand()
])

<div
    class="rounded-md"
    x-data="{
        value: @entangle($attributes->wire('model')).live,
        isFocused() { return document.activeElement !== this.$refs.trix},
        setValue() { this.$refs.trix.editor.loadHTML(this.value)},
    }"
    x-init = "setValue(); $watch('value', () => isFocused() && setValue())"
    x-on:trix-change="value = $event.target.value"
    {{ $attributes->whereDoesntStartWith('wire:model.live')}}
    wire:ignore
>
@if(!is_null($label))
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
@endif
    <input id="x" type="hidden">

    @if(isset($attributes['hide_toolbar']) && !empty($attributes['hide_toolbar']))
        <div id="blank-toolbar" hidden></div>
    @endif

    <trix-editor
        x-ref="trix"
        input="x"
        class="form-control"
        @if(isset($attributes['hide_toolbar']) && !empty($attributes['hide_toolbar']))
            toolbar="blank-toolbar"
        @endif
        @if(!is_null($placeholder))
            placeholder="{{ $placeholder }}"
        @endif
    ></trix-editor>
</div>
