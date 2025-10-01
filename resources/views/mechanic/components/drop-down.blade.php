<div>
    @can('My Mechanic - Edit')
        <x-input.buttons.action.actions class="Z-0 hover:cursor-pointer" action="Edit" :type="'button'" allow="true" primary
                                        onclick="Livewire.dispatch('openModal', {component: 'Mechanic.edit', arguments: {{ json_encode([$id]) }} })">
            <x-input.buttons.action.action-link
                onclick="Livewire.dispatch('openModal', {component: 'Availability', arguments: {{ json_encode(['subjectId'=>$id,'subject'=>get_class($model)]) }} })">
                Availability
            </x-input.buttons.action.action-link>
            @can('My Mechanic - Remove')
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
