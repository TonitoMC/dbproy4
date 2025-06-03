<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */

class RoleFactory extends Factory
{

    public function definition(): array
    {
        return [
            // This is overriden by the seeder, this is just for
            // a fallback
            'name' => $this->fake->unique()->word . ' Role',
            'description' => $this->faker->optional()->sentence(),
        ];
    }

}
