<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->optional()->sentence(),
            'stage' => fake()->randomElement([
                'foundation', 'rebar', 'formwork', 'slab',
                'wall_elevation', 'framing', 'roofing',
                'electrical', 'plumbing', 'tiling', 'painting', 'finishing',
            ]),
            'status' => fake()->randomElement(['not_started', 'in_progress', 'completed']),
            'start_date' => fake()->optional()->date(),
            'expected_end_date' => fake()->optional()->date(),
            'actual_end_date' => fake()->optional()->date(),
            'progress' => fake()->numberBetween(0, 100),
            'user_id' => User::factory(),
        ];
    }
}
