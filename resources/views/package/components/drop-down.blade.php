<div>
    @can('Admin Mechanic')
        <x-input.buttons.action.actions class="Z-0 hover:cursor-pointer" action="Edit" :type="'button'" allow="true" primary
                                        onclick="Livewire.dispatch('openModal', {component: 'package.edit', arguments: {{ json_encode([$id]) }} })">

            @can('Admin Mechanic')
                <x-input.buttons.action.action-link
                    wire:click="confirmRemove('{{$id}}')">
                    Remove
                </x-input.buttons.action.action-link>
            @endcan

        </x-input.buttons.action.actions>
    @else
        <div class="text-2xs text-gray-500">No actions</div>
    @endcan
</div>
