<div>
    @can('My Operators')
        <x-input.buttons.action.actions class="Z-0 hover:cursor-pointer" action="Open" :type="'button'" allow="true" primary
                                        onclick="Livewire.dispatch('openModal', {component: 'operator.edit', arguments: {{ json_encode([$id]) }} })">

            @can('My Operators')
            <x-input.buttons.action.action-link
                wire:click="confirmRemove('{{$id}}')">
                Remove
            </x-input.buttons.action.action-link>
            @endcan
{{--            @can('My Operators')--}}
{{--            <x-input.buttons.action.action-link--}}
{{--                onclick="Livewire.dispatch('openModal', {component: 'Admin.Users.UserActivity', arguments: {{ json_encode([$id]) }} })">--}}
{{--                Rentals--}}
{{--            </x-input.buttons.action.action-link>--}}
{{--            @endcan--}}
        </x-input.buttons.action.actions>
    @else
        <div class="text-2xs text-gray-500">No actions</div>
    @endcan
</div>
