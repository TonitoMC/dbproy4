<?php

namespace Database\Factories;

use App\Models\Product; // ADD THIS LINE
use App\Models\User;     // ADD THIS LINE
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->paragraph(),
            'is_approved' => $this->faker->boolean(80),
        ];
    }
}
