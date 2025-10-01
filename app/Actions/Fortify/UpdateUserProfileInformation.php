<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
//        dd($user);
        Validator::make($input, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'memberName' => ['exclude_if:type,Company','required', 'string', 'max:255'],
            'number' => ['exclude_if:type,Company','required', 'string', 'max:255'],
            //company
            'companyName' => ['exclude_if:type,Personal','required', 'string', 'max:255'],
            'companyContact' => ['exclude_if:type,Personal','required', 'string', 'max:255'],
            'companyNumber' => ['exclude_if:type,Personal','required', 'string', 'max:255'],
            'website' => ['exclude_if:type,Personal','required', 'string', 'max:255'],
            //shared
            'address' => ['required', 'string'],
            'type' => ['required', 'string'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'memberName' => $input['memberName'],
                'number' => $input['number'],
                'companyName' => $input['companyName'],
                'companyContact' => $input['companyContact'],
                'companyNumber' => $input['companyNumber'],
                'website' => $input['website'],
                'address' => $input['address'],
                'type' => $input['type'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'memberName' => $input['name'],
            'number' => $input['number'],
            'companyName' => $input['companyName'],
            'companyContact' => $input['companyContact'],
            'companyNumber' => $input['companyNumber'],
            'website' => $input['website'],
            'address' => $input['address'],
            'type' => $input['type'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
