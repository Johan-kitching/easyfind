<div>
    @can('Admin Users - Edit')
        <x-input.buttons.action.actions class="Z-0 hover:cursor-pointer" action="Edit" :type="'link'" allow="true"
                                        onclick="Livewire.dispatch('openModal', {component: 'Admin.Permissions.ViewPermissions', arguments: {{ json_encode([$id]) }} })"/>
    @else
        <div class="text-2xs text-gray-500">No actions</div>
    @endcan
</div>
