<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Api extends ModalComponent
{

    public User $user;
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }
    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('users.api');
    }
}
