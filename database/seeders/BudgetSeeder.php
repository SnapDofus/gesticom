<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) return;

        $budgets = [
            ['category' => 'global', 'planned_amount' => 1500000],
            ['category' => 'materials', 'planned_amount' => 800000],
            ['category' => 'labor', 'planned_amount' => 400000],
            ['category' => 'transport', 'planned_amount' => 150000],
            ['category' => 'misc', 'planned_amount' => 150000],
        ];

        foreach ($budgets as $budget) {
            Budget::create([
                'category' => $budget['category'],
                'planned_amount' => $budget['planned_amount'],
                'spent_amount' => 0,
                'user_id' => $user->id,
            ]);
        }
    }
}
