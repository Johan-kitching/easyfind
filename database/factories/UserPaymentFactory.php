<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserPaymentFactory extends Factory
{
    protected $model = UserPayment::class;

    public function definition(): array
    {
        return [
            'amount' => $this->faker->word(),
            'response' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'package_id' => Package::factory(),
        ];
    }
}
