<div wire:ignore x-data x-init="
    const pond = FilePond.create($refs.input, {
        allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
            },
            revert: (filename, load) => {
                @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
            },
        },
        allowImagePreview: {{ isset($attributes['allowImagePreview']) ? 'true' : 'false' }},
        allowReorder:false,
        allowImageEditor:false,
        onaddfilestart: function(file) {
                        submitButtonDisabled++;
                    },
        onprocessfile: function(file) {
                        submitButtonDisabled--;
                    },
    });

    this.addEventListener('pondReset', e => {
        pond.removeFiles();
    });

">
    @if($attributes['label'])
        <label for="{{ $attributes['wire:model'] }}" class="block text-sm font-medium disabled:opacity-60 text-gray-700 dark:text-gray-400 invalidated:text-negative-600 dark:invalidated:text-negative-700"
               @error($attributes['wire:model']) class="text-red" @enderror>{{$attributes['label']}}</label>
    @endif
    <input type="file"
           x-ref="input" {!! isset($attributes['accept']) ? 'accept="' . $attributes['accept'] . '"' : '' !!} {!! isset($attributes['allowImagePreview']) ? 'allowImagePreview="' . $attributes['allowImagePreview'] . '"' : '' !!}
        {{--           captureMethod="camera" capture="environment"--}}
    >
</div>
