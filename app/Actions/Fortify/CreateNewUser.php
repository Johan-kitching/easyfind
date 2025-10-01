<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public User $user;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            //personal
            'memberName' => ['exclude_if:type,Company', 'required', 'string', 'max:255'],
            'number' => ['exclude_if:type,Company', 'required', 'string', 'max:255'],
            //company
            'companyName' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'companyContact' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'companyNumber' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'website' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            //shared
            'address' => ['required', 'string'],
            'address_latitude' => ['required', 'string'],
            'address_longitude' => ['required', 'string'],
            'city' => ['required', 'string'],
            'type' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['same:password'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        $this->user = User::create([
            'memberName' => $input['memberName'],
            'number' => $input['number'],
            'companyName' => $input['companyName'],
            'address' => $input['address'],
            'companyContact' => $input['companyContact'],
            'companyNumber' => $input['companyNumber'],
            'website' => $input['website'],
            'type' => $input['type'],
            'email' => $input['email'],
            'terms' => $input['terms'],
            'password' => Hash::make($input['password']),
        ]);
        $this->user->address()->create([
            'name' => $input['address'],
            'address' => $input['address'],
            'address_latitude' => $input['address_latitude'],
            'address_longitude' => $input['address_longitude'],
            'city' => $input['city'],
            ]);
        $this->user->assignRole('User');
        return $this->user;
    }
}
