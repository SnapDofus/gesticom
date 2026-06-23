<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => fake()->sentence(3),
            'amount' => fake()->randomFloat(2, 1000, 500000),
            'category' => fake()->randomElement(['materials', 'labor', 'transport', 'misc']),
            'date' => fake()->date(),
            'receipt' => null,
            'observation' => fake()->optional()->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
