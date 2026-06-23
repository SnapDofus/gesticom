<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'quantity_planned' => fake()->randomFloat(2, 1, 1000),
            'quantity_purchased' => fake()->randomFloat(2, 0, 500),
            'estimated_price' => fake()->randomFloat(2, 100, 100000),
            'actual_price' => fake()->optional()->randomFloat(2, 100, 100000),
            'supplier' => fake()->optional()->company(),
            'purchase_date' => fake()->optional()->date(),
            'status' => fake()->randomElement(['not_purchased', 'partially_purchased', 'fully_purchased']),
            'observation' => fake()->optional()->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
