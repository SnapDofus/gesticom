<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerPaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'worker_id' => Worker::factory(),
            'date' => fake()->date(),
            'amount' => fake()->randomFloat(2, 5000, 100000),
            'observation' => fake()->optional()->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
