<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $user;
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * Update the user's password.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserPasswords  $updater
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater, User $users)
    {
        $this->resetErrorBag();
        $user = $users->find($this->user->id);
        $user->password = Hash::make($this->state['password']);
        $user->update();

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('admin.users.components.update-password-form');
    }
}
