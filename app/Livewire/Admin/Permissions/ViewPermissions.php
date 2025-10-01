<?php

namespace App\Livewire\Admin\Permissions;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ViewPermissions extends ModalComponent
{
    public $userType;
    public $name;
    public $role;
    public $permissions;
    public $currentPermission;
    public $new ='false';
    public $prev = null;

    public $rules = [
        'name' => ['required', 'string']
    ];


    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function mount(Role $role): void
    {
        $this->name = $role->name;
        $this->role = $role;
        $this->permissions = Permission::all()->sortBy('name')->toArray();
        foreach ($this->permissions as $key){
            $this->currentPermission[$key['id']] = false;
        }
        foreach($role->permissions()->get() as $key){
            $this->currentPermission[$key->id] = true;
        }

    }

    public function save(Role $role): void
    {
        $this->validate();
        foreach($this->currentPermission as $key=>$value) {
            if($value){
                $this->role->givePermissionTo(Permission::findById($key, 'web'));
            }else{
                $this->role->revokePermissionTo(Permission::findById($key, 'web'));
            }
        }
//        dd($this->currentPermission, $this->role->permissions()->get());
        $this->dispatch('permissionTable');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('admin.users.permissions-show');
    }

}
