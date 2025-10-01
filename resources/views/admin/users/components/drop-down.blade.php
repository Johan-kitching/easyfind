<div>
    @can('Admin Users - Edit')
        <x-input.buttons.action.actions class="Z-0 hover:cursor-pointer" action="Open" :type="'button'" allow="true" primary
                                        onclick="location.href='{{route('admin.edit.user',['user'=>$id])}}';">

            @can('Admin Users - Remove')
            <x-input.buttons.action.action-link
                wire:click="confirmRemove('{{$id}}')">
                Remove
            </x-input.buttons.action.action-link>
            @endcan
            @can('Admin Users - Activity')
            <x-input.buttons.action.action-link
                onclick="Livewire.dispatch('openModal', {component: 'Admin.Users.UserActivity', arguments: {{ json_encode([$id]) }} })">
                Activity
            </x-input.buttons.action.action-link>
            @endcan
            @can('Admin Users - API')
            <x-input.buttons.action.action-link
                onclick="Livewire.dispatch('openModal', {component: 'Admin.Users.Api', arguments: {{ json_encode([$id]) }} })">
                API
            </x-input.buttons.action.action-link>
            @endcan
        </x-input.buttons.action.actions>
    @else
        <div class="text-2xs text-gray-500">No actions</div>
    @endcan
</div>
