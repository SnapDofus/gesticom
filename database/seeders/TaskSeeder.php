<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) return;

        $stages = [
            ['name' => 'Fondation', 'stage' => 'foundation'],
            ['name' => 'Ferraillage', 'stage' => 'rebar'],
            ['name' => 'Coffrage', 'stage' => 'formwork'],
            ['name' => 'Dallage', 'stage' => 'slab'],
            ['name' => 'Élévation des murs', 'stage' => 'wall_elevation'],
            ['name' => 'Charpente', 'stage' => 'framing'],
            ['name' => 'Toiture', 'stage' => 'roofing'],
            ['name' => 'Électricité', 'stage' => 'electrical'],
            ['name' => 'Plomberie', 'stage' => 'plumbing'],
            ['name' => 'Carrelage', 'stage' => 'tiling'],
            ['name' => 'Peinture', 'stage' => 'painting'],
            ['name' => 'Finitions', 'stage' => 'finishing'],
        ];

        foreach ($stages as $stage) {
            Task::create([
                'name' => $stage['name'],
                'description' => null,
                'stage' => $stage['stage'],
                'status' => 'not_started',
                'start_date' => null,
                'expected_end_date' => null,
                'actual_end_date' => null,
                'progress' => 0,
                'user_id' => $user->id,
            ]);
        }
    }
}
