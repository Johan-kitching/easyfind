<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class UpdateUserInformationForm extends Component
{
    use WithFileUploads, WireUiActions;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Determine if the verification email was sent.
     *
     * @var bool
     */
    public $verificationLinkSent = false;
    public \Illuminate\Contracts\Auth\Authenticatable|null|User $user;

    /**
     * Prepare the component.
     *
     * @param User $user
     * @return void
     */
    public function mount(User $user)
    {

        $this->user = $user;

        $this->state = array_merge([
            'email' => $user->email,
            'name' => $user->name,
            'number' => $user->number,
        ], $this->user->withoutRelations()->toArray());

    }

    /**
     * Update the user's profile information.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserProfileInformation $updater
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            $this->user,
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

//        if (isset($this->photo)) {
////            dd(Route::current());
//            return refresh();
//            return redirect()->route(Route::current());
//        }
        $this->notification()->send([
            'icon' => 'info',
            'title' => 'Saved!',
            'description' => 'The Profile has been saved.',
        ]);
        $this->dispatch('saved');
    }

    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        $this->user->deleteProfilePhoto();
    }

    /**
     * Sent the email verification.
     *
     * @return void
     */
    public function sendEmailVerification()
    {
        $this->user->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return $this->user;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile.update-profile-information-form');
    }
}
