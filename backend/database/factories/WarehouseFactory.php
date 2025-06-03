<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->city() . ' Distribution Center',
            'location' => $this->faker->address(),
            'manager_name' => $this->faker->name(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
