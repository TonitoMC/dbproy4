<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company() . ' Supplier',
            'email' => $this->faker->unique()->companyemail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
