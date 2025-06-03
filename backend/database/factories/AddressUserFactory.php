<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddressUser>
 */
class AddressUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['Shipping', 'Billing', 'Home', 'Work']),
            'is_default' => $this->faker->boolean(20),
        ];
    }
}
