<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create the user
        $user = User::firstOrCreate([
            'name' => 'Johan Kitching',
            'email' => 'johankit@gmail.com',
            'password' => Hash::make('Morning@12'),
            'address' => $faker->address,
        ]);

        // Assign the "Super Admin" role to the user
        $role = Role::where('name', 'Super Admin')->first();
        if ($role) {
            $user->assignRole($role);
        }
    }
}
