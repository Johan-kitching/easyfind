<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserAddressInformation2 implements UpdatesUserProfileInformation
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
