<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class UserActivity extends ModalComponent
{

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('admin.users.components.user-activity-grid');
    }
}
