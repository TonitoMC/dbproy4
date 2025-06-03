<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $parent_id = $this->faker->boolean(70)
                   ? null
                   : Category::inRandomOrder()->first()?->id;

        return [
            'name' => $this->faker->unique()->word() . ' Category',
            'description' => $this->faker->optional()->sentence(),
            'parent_id' => $parent_id,
            'is_active' => $this->faker->boolean(),
        ];
    }
}
