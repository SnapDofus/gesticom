<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'function' => fake()->jobTitle(),
            'daily_wage' => fake()->randomFloat(2, 5000, 15000),
            'user_id' => User::factory(),
        ];
    }
}
